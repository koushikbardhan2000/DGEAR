#!/usr/bin/env Rscript

args <- commandArgs(trailingOnly = TRUE)
count_file <- args[1]            # path to raw counts file
con1 <- as.numeric(args[2])      # control group start column index
con2 <- as.numeric(args[3])      # control group end column index
exp1 <- as.numeric(args[4])      # experimental group start column index
exp2 <- as.numeric(args[5])      # experimental group end column index
alpha <- as.numeric(args[6])     # significance threshold (e.g. 0.05)
votting_cutoff <- as.numeric(args[7])  # ensemble score threshold

# Load libraries
suppressMessages({
  library("DESeq2")
  library("edgeR")
  library(limma)
  library(data.table)
  library(metapod)
})

# Load and organize data
dataframe <- read.delim(count_file, row.names = 1)
con <- dataframe[, con1:con2]
exp <- dataframe[, exp1:exp2]
tbl <- cbind(con, exp)

# Sample grouping
group_control <- rep("Control", ncol(con))
group_treated <- rep("Treated", ncol(exp))
group_labels <- factor(c(group_control, group_treated))
groups <- make.names(c("Treated", "Control"))
group_labels <- relevel(group_labels, ref = "Control")


sample_info <- data.frame(Group = group_labels, row.names = colnames(tbl))
grp.idx <- group_labels

# Pre-filter low count genes
keep <- rowSums(tbl >= 10) >= min(table(group_labels))
tbl <- tbl[keep, ]

###------------------------###
###     DESeq2 Section     ###
###------------------------###
ds <- DESeqDataSetFromMatrix(countData = tbl, colData = sample_info, design = ~Group)
ds <- DESeq(ds, test = "Wald", sfType = "poscount")
r <- results(ds, contrast = c("Group", groups[1], groups[2]), alpha = alpha, pAdjustMethod = "fdr")

DESeq2 <- as.data.frame(r[order(r$padj), ])
DESeq2 <- subset(DESeq2, select = c("padj", "pvalue", "stat", "log2FoldChange"))
DESeq2$GeneID <- rownames(DESeq2)
DESeq2$fdr <- ifelse(DESeq2$padj <= alpha, 1, 0)
DESeq2 <- na.omit(DESeq2[DESeq2$fdr == 1, ])
DESeq2 <- DESeq2[order(DESeq2$padj), ]
write.csv(DESeq2, "/var/www/DGEAR/csv/VER1.csv", row.names = FALSE)


###------------------------###
###      edgeR Section     ###
###------------------------###
dgel <- DGEList(counts = tbl, group = grp.idx)
dgel <- calcNormFactors(dgel)
dgel <- estimateCommonDisp(dgel)
dgel <- estimateTagwiseDisp(dgel)
et <- exactTest(dgel)
et$table$p.adj <- p.adjust(et$table$PValue, method = "BH")

edgeR <- data.frame(et$table)
edgeR$fdr <- ifelse(edgeR$p.adj <= alpha, 1, 0)
edgeR <- edgeR[edgeR$fdr == 1, ]
edgeR <- na.omit(edgeR[order(edgeR$p.adj), ])
edgeR$GeneID <- rownames(edgeR)
edgeR <- edgeR[, c("GeneID", "logFC", "logCPM", "PValue", "p.adj", "fdr")]
write.csv(edgeR, "/var/www/DGEAR/csv/VER2.csv", row.names = FALSE)
###------------------------###
###   limma-voom Section   ###
###------------------------###
dgel2 <- DGEList(counts = tbl, group = grp.idx)
dgel2 <- calcNormFactors(dgel2)
design <- model.matrix(~grp.idx)
log2.cpm <- voom(dgel2, design)
fit <- lmFit(log2.cpm, design)
fit <- eBayes(fit)
limma.res <- topTable(fit, coef = 2, n = Inf, sort.by = "p")

limma <- data.frame(limma.res)
limma$fdr <- ifelse(limma$adj.P.Val <= alpha, 1, 0)
limma <- limma[limma$fdr == 1, ]
limma <- na.omit(limma[order(limma$adj.P.Val), ])
limma$GeneID <- rownames(limma)
limma <- limma[, c("GeneID", names(limma)[1:7])]
write.csv(limma, "/var/www/DGEAR/csv/VER3.csv", row.names = FALSE)

###------------------------###
###     Ensemble Merge     ###
###------------------------###
raw_counts <- as.data.frame(read.delim(count_file))
x_merge <- merge(raw_counts, DESeq2, by.x = "GeneID", by.y = "GeneID", all.x = TRUE)
y_merge <- merge(x_merge, limma, by.x = "GeneID", by.y = "GeneID", all.x = TRUE)
z_merge <- merge(y_merge, edgeR, by.x = "GeneID", by.y = "GeneID", all.x = TRUE)

# Ensemble score calculation
final_merge <- z_merge
final_merge$DESeq2_hit <- ifelse(!is.na(final_merge$padj), 1, 0)
final_merge$limma_hit  <- ifelse(!is.na(final_merge$adj.P.Val), 1, 0)
final_merge$edgeR_hit  <- ifelse(!is.na(final_merge$p.adj), 1, 0)

final_merge$Ensemble_score <- final_merge$DESeq2_hit + final_merge$limma_hit + final_merge$edgeR_hit

# Filter DEGs
DEGs <- final_merge[final_merge$Ensemble_score >= votting_cutoff, ]
DEGs <- DEGs[, c("GeneID", "Ensemble_score")]

###------------------------###
###   Combined P-values    ###
###------------------------###
P.adj.Val <- z_merge[, c("GeneID", "padj", "adj.P.Val", "p.adj")]
p1 <- as.vector(P.adj.Val$padj)
p2 <- as.vector(P.adj.Val$adj.P.Val)
p3 <- as.vector(P.adj.Val$p.adj)
P <- list("DESeq2" = p1, "limma" = p2, "edgeR" = p3)
P.adj.Val_combined <- parallelFisher(P)
P.adj.Val$P.adj.Val_combined <- P.adj.Val_combined$p.value

###------------------------###
###  Mean log2FC Combine   ###
###------------------------###
# Collect available log2FC columns from merged result
available_cols <- colnames(z_merge)
log2fc_cols <- c(
  if ("log2FoldChange" %in% available_cols) "log2FoldChange" else NULL,
  if ("logFC" %in% available_cols) "logFC" else NULL,
  if ("logFC.1" %in% available_cols) "logFC.1" else NULL
)

log2FC_merge <- z_merge[, c("GeneID", log2fc_cols)]

# Handle different number of columns
if (length(log2fc_cols) >= 2) {
  log2FC_merge$log2FC_mean <- rowMeans(log2FC_merge[, log2fc_cols], na.rm = TRUE)
} else if (length(log2fc_cols) == 1) {
  log2FC_merge$log2FC_mean <- log2FC_merge[[log2fc_cols[1]]]
} else {
  stop("No valid log2FC columns found for averaging.")
}


###------------------------###
###    Final Output File   ###
###------------------------###
output <- data.frame(
  GeneID = log2FC_merge$GeneID,
  P.adj.Val_combined = P.adj.Val$P.adj.Val_combined,
  log2FC = log2FC_merge$log2FC_mean,
  Ensemble_score = final_merge$Ensemble_score
)

output <- output[output$Ensemble_score >= votting_cutoff, ]
output <- na.omit(output)

# Write to file (optional)
write.csv(output, "/var/www/DGEAR/csv/RNAseq_significant.csv", row.names = FALSE)



# GESA with enrichR
library(enrichR)
gene_list = output$GeneID
dbs <- c("GO_Molecular_Function_2021",
         "GO_Cellular_Component_2021",
         "GO_Biological_Process_2021")
enriched = enrichr(gene_list, dbs)

file_name = paste0("/var/www/DGEAR/plots/rna-seq/GO_Enrichment_", names(enriched)[1], ".png")
png(file_name, width = 1200, height = 800, res = 150)
plotEnrich(enriched[[1]], title = paste("GO_Enrichment:", names(enriched)[1]),showTerms = 10, numChar = 40, y = "Count", orderBy = "P.value")
dev.off()

file_name = paste0("/var/www/DGEAR/plots/rna-seq/GO_Enrichment_", names(enriched)[2], ".png")
png(file_name, width = 1200, height = 800, res = 150)
plotEnrich(enriched[[2]], title = paste("GO_Enrichment:", names(enriched)[2]),showTerms = 10, numChar = 40, y = "Count", orderBy = "P.value")
dev.off()

file_name = paste0("/var/www/DGEAR/plots/rna-seq/GO_Enrichment_", names(enriched)[3], ".png")
png(file_name, width = 1200, height = 800, res = 150)
plotEnrich(enriched[[3]], title = paste("GO_Enrichment:", names(enriched)[3]),showTerms = 10, numChar = 40, y = "Count", orderBy = "P.value")
dev.off()
