#!/usr/bin/Rscript --vanilla
#from the cmd type bash to enter ubuntu terminal
#sudo apt-get install r-base-core was done to be able to run Rscript command in the terminal # nolint
#pwd: /mnt/d/DISSERTATION/DEG
#To run the r script set the parameters as: Rscript RunCopy.R "OUTPUT/merged_sep_no_dup1.txt" 1 105 106 234 0.005 3 # nolint

#######____Main____
arg = commandArgs(trailingOnly = T)
dataframe <- data.frame(read.delim(arg[1], row.names = 1))
con1 = as.numeric(arg[2])
con2 = as.numeric(arg[3])
exp1 = as.numeric(arg[4])
exp2 = as.numeric(arg[5])
con= dataframe[,eval(con1:con2)]
exp= dataframe[,eval(exp1:exp2)]
con_m = rowMeans(con)
exp_m = rowMeans(exp)
alpha = as.numeric(arg[6])
votting_cutoff = as.numeric(arg[7])
ID=data.frame("Gene"=row.names(dataframe))


options(warn = - 1) # to ignore warnings globally.
# set warn = 0 to get back to normal.
#libraries
suppressMessages({
  library("DescTools")  # for Dunnett's test
  library("enrichR") # for GSEA
  library("STRINGdb") # for PPI network
  library("igraph") # for PPI network visualization and plotting
  library("future.apply") # for parallel processing
})

xm2 <- as.numeric(quantile(dataframe, c(0., 0.25, 0.5, 0.75, 0.99, 1.0), na.rm=T))
LogC <- (xm2[5] > 100) || (xm2[6]-xm2[1] > 50 && xm2[2] > 0)
if (LogC) { #expmat2[which(expmat2 <= 0)] <- NaN #If there is any zero in the dataframe then, "Error in `[<-.data.frame`(`*tmp*`, which(expmat2 <= 0), value = NaN) : new columns would leave holes after existing columns", thus commented.
  dataframe <- log2(dataframe) #1
  con= dataframe[,eval(con1:con2)]#2
  exp= dataframe[,eval(exp1:exp2)]#2
  con_m = rowMeans(con)#3
  exp_m = rowMeans(exp)#3
  log2FC <- exp_m-con_m #4
} else {log2FC <- exp_m-con_m
}

# Set the parallel plan once at the top
plan(multisession, workers = availableCores() - 1)

# ---- t-test ----
t_test_function <- function(i) {
  t = t.test(con[i, ], exp[i, ])
  return(c(statistic = t$statistic, p.value = t$p.value))
}

t_results <- future_sapply(seq_len(nrow(dataframe)), t_test_function)
t_stat <- data.frame(ID, log2FC, t(t_results))
t_stat$BH = p.adjust(t_stat$p.value, method = "BH")
t_stat$fdr = as.numeric(t_stat$BH <= alpha)

write.csv(t_stat, "/var/www/DGEAR/csv/t_stat_significant.csv", row.names = F)
# write.csv(as.data.frame(na.omit(t_stat[t_stat$fdr == 1,-ncol(t_stat)])),
          # "/var/www/DGEAR/csv/t_stat_significant.csv", row.names = F)


# ---- ANOVA ----
group = factor(c(rep("con", length(eval(con1:con2))), rep("tre", length(eval(exp1:exp2)))))

anova_results <- future_apply(dataframe, 1, function(x) {
  result = oneway.test(x ~ group)
  c(statistic = result$statistic, p.value = result$p.value)
})

o_stat <- data.frame(ID, log2FC, t(anova_results))
o_stat$BH = p.adjust(o_stat$p.value, method = "BH")
o_stat$fdr = as.numeric(o_stat$BH <= alpha)

write.csv(o_stat, "/var/www/DGEAR/csv/o_stat_significant.csv", row.names = F)
# write.csv(as.data.frame(na.omit(o_stat[o_stat$fdr == 1,-ncol(o_stat)])),
#           "/var/www/DGEAR/csv/o_stat_significant.csv", row.names = F)



# ---- Dunnett's test ----
group = factor(c(rep("con", length(con)), rep("tre", length(exp))))
dataframe = t(dataframe)

d_test_function <- function(i) {
  x = dataframe[, i]
  d = DescTools::DunnettTest(x, group)
  return(d$con[, 4])
}

p.values <- future_sapply(1:ncol(dataframe), d_test_function)

dataframe = t(dataframe)
d_stat <- data.frame(ID, log2FC, p.value = p.values)
d_stat$BH = p.adjust(d_stat$p.value, method = "BH")
d_stat$fdr = as.numeric(d_stat$BH <= alpha)

write.csv(d_stat, "/var/www/DGEAR/csv/d_stat_significant.csv", row.names = F)
# write.csv(as.data.frame(na.omit(d_stat[d_stat$fdr == 1,-ncol(d_stat)])),
#           "/var/www/DGEAR/csv/d_stat_significant.csv", row.names = F)


# ---- Half’s t-test ----
half_t_stat <- data.frame(
  ID,
  log2FC = log2FC,
  statistic = (exp_m - con_m) / (apply(con, 1, sd) * sqrt((1/ncol(exp)) + (1/ncol(con)))),
  stringsAsFactors = FALSE
)

half_t_stat$p.value <- 2 * pt(abs(half_t_stat$statistic), df = nrow(con) - 1, lower.tail = FALSE)
half_t_stat$BH <- p.adjust(half_t_stat$p.value, method = "BH")
half_t_stat$fdr <- as.numeric(half_t_stat$BH <= alpha)

write.csv(half_t_stat, "/var/www/DGEAR/csv/half_t_stat_significant.csv", row.names = F)
# write.csv(as.data.frame(na.omit(half_t_stat[half_t_stat$fdr == 1,-ncol(half_t_stat)])),
#           "/var/www/DGEAR/csv/half_t_stat_significant.csv", row.names = F)


# ---- Wilcoxon test ----
wilcox_results <- t(future_sapply(1:nrow(dataframe), function(i) {
  x = as.numeric(con[i, ])
  y = as.numeric(exp[i, ])
  result = wilcox.test(x, y)
  c(statistic = result$statistic, p.value = result$p.value)
}))

u_stat <- data.frame(ID, log2FC, wilcox_results)
u_stat$BH = p.adjust(u_stat$p.value, method = "BH")
u_stat$fdr = as.numeric(u_stat$BH <= alpha)

write.csv(u_stat, "/var/www/DGEAR/csv/u_stat_significant.csv", row.names = F)
# write.csv(as.data.frame(na.omit(u_stat[u_stat$fdr == 1,-ncol(u_stat)])),
#           "/var/www/DGEAR/csv/u_stat_significant.csv", row.names = F)



######### ____ENSEMBL_____
df = data.frame("T-FDR"= t_stat$fdr,
                "O-FDR" = o_stat$fdr,
                "D-FDR" = d_stat$fdr,
                "H-FDR" = half_t_stat$fdr,
                "W-FDR" = u_stat$fdr)
row.names(df)= rownames(dataframe)
df[is.na(df)] <- 0


DF = data.frame(DEGs = row.names(df[rowSums(df) >= votting_cutoff,]))
Enemble_score = data.frame(ID, "Enemble_score"=rowSums(df))
##>edited

library("metapod") #parallelFisher()
P = list("P1"=t_stat$BH,"P2"=o_stat$BH,"P3"=d_stat$BH,"P4"=half_t_stat$BH,"P5"=u_stat$BH)
CombineFDR = parallelFisher(P)
CombineFDR = CombineFDR$p.value

FDR_Table = data.frame(ID, log2FC,
                       "T-FDR" = t_stat$BH,
                       "O-FDR" = o_stat$BH,
                       "D-FDR" = d_stat$BH,
                       "H-FDR" = half_t_stat$BH,
                       "W-FDR" = u_stat$BH,
                       "CombineFDR" = CombineFDR,
                       "Ensemble" = rowSums(df))

Results_Table = data.frame(ID, 
                           "CombineFDR" = CombineFDR,
                           log2FC,
                           "Ensemble" = rowSums(df))
write.csv(Results_Table, "/var/www/DGEAR/csv/ensembl_sigificant.csv", row.names = F)

df$mark <- ifelse(rowSums(df) >= votting_cutoff, 'significant', 'not')


# #########____ENSEMBL_____

# df = cbind.data.frame(T_statistics = as.numeric(t_stat$fdr),
#                       O_statistics = as.numeric(o_stat$fdr),
#                       D_statistics = as.numeric(d_stat$fdr),
#                       HT_statistics = as.numeric(half_t_stat$fdr),
#                       U_statistics = as.numeric(u_stat$fdr))
# row.names(df)= t_stat$ID
# df[is.na(df)] <- 0
# write.csv(row.names(df[rowSums(df) >= votting_cutoff,]),
#           "/var/www/DGEAR/csv/ensembl_sigificant.csv", row.names = F)
# df$mark <- ifelse(rowSums(df) >= votting_cutoff, 'significant', 'not')


######### ____HeatMap____
ensembl_significant = as.data.frame(dataframe[df$mark =="significant",])
ensembl_significant <- scale(ensembl_significant)

pdf("/var/www/DGEAR/plots/heatmap.pdf")
heatmap(ensembl_significant,
        cexRow =0.7,#font size of rows
        cexCol = 1,#font size of columns
       main = "Heatmap_",
        xlab = "Samples", ylab = "Gene_Symbols")
dev.off()
png("/var/www/DGEAR/plots/heatmap.png")
heatmap(ensembl_significant,
        cexRow =0.7,#font size of rows
        cexCol = 1,#font size of columns
        main = "Heatmap_",
        xlab = "Samples", ylab = "Gene_Symbols")
dev.off()


#Rscript /var/www/html/webtool/RunCopy.R /var/www/html/webtool/uploads/merged_sep_no_dup-truncated.txt 1 105 106 234 0.005 3



# GESA with enrichR
# library(enrichR)
gene_list = row.names(ensembl_significant)
dbs <- c("GO_Molecular_Function_2021",
         "GO_Cellular_Component_2021",
         "GO_Biological_Process_2021")
enriched = enrichr(gene_list, dbs)

file_name = paste0("/var/www/DGEAR/plots/GO_Enrichment_", names(enriched)[1], ".png")
png(file_name, width = 1200, height = 800, res = 150)
plotEnrich(enriched[[1]], title = paste("GO_Enrichment:", names(enriched)[1]),showTerms = 10, numChar = 40, y = "Count", orderBy = "P.value")
dev.off()

file_name = paste0("/var/www/DGEAR/plots/GO_Enrichment_", names(enriched)[2], ".png")
png(file_name, width = 1200, height = 800, res = 150)
plotEnrich(enriched[[2]], title = paste("GO_Enrichment:", names(enriched)[2]),showTerms = 10, numChar = 40, y = "Count", orderBy = "P.value")
dev.off()

file_name = paste0("/var/www/DGEAR/plots/GO_Enrichment_", names(enriched)[3], ".png")
png(file_name, width = 1200, height = 800, res = 150)
plotEnrich(enriched[[3]], title = paste("GO_Enrichment:", names(enriched)[3]),showTerms = 10, numChar = 40, y = "Count", orderBy = "P.value")
dev.off()



#############################################
# PPI with STRINGdb (online version)
#############################################
# Load necessary libraries
# library(STRINGdb)
# library(igraph)

# gene list dataframe for STRINGdb
gene_list <- data.frame(genes = row.names(ensembl_significant)[seq_len(min(50, nrow(ensembl_significant)))])
# [1:min(50, nrow(ensembl_significant))] only build upto 50 genes ppi network
# Initialize STRINGdb and map genes
string_db <- STRINGdb$new(version="11.5", species=9606, score_threshold=400, input_directory="")
mapped_data <- string_db$map(gene_list, "genes", removeUnmappedRows = TRUE)

# Get PPI interactions
ppi_network <- string_db$get_interactions(mapped_data$STRING_id)

# Build igraph object
ppi_graph <- graph_from_data_frame(ppi_network, directed = FALSE)

# Replace STRING IDs with gene symbols
V(ppi_graph)$label <- mapped_data$genes[match(V(ppi_graph)$name, mapped_data$STRING_id)]

# Compute node degree centrality
V(ppi_graph)$degree <- degree(ppi_graph)

# Set color and size by degree
V(ppi_graph)$color <- heat.colors(max(V(ppi_graph)$degree) + 1)[V(ppi_graph)$degree + 1]
V(ppi_graph)$size <- 5 + V(ppi_graph)$degree * 2

# Plot using igraph
png("/var/www/DGEAR/plots/PPI_network_igraph.png", width = 1200, height = 800, res = 150)
plot(ppi_graph,
     vertex.label = V(ppi_graph)$label,
     vertex.label.cex = 0.8,
     vertex.label.dist = 0.5,
     vertex.label.color = "black",
     vertex.frame.color = "white",
     layout = layout_with_fr(ppi_graph))
dev.off()
