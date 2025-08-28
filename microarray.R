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



options(warn = - 1) # to ignore warnings globally.
# set warn = 0 to get back to normal.
#libraries
suppressMessages({
  library("DescTools")
  library("enrichR")
  library("STRINGdb")
  library("igraph")
})

#######____t-test____
p.value = NULL
statistic = NULL 
for(i in seq_len(nrow(dataframe))) {
  x = con[i,] 
  y = exp[i,] 
  t = t.test(x, y)
  p.value[i] = t$p.value
  statistic[i] = t$statistic
}

t_stat = cbind.data.frame(ID=row.names(dataframe),statistic,p.value)
t_stat$fdr[t_stat$p.value<=(alpha/nrow(t_stat))*seq_len(nrow(t_stat))] <- 1
write.csv(as.data.frame(na.omit(t_stat[t_stat$fdr == 1,-ncol(t_stat)])),
          "/var/www/DGEAR/csv/t_stat_significant.csv", row.names = F)


#######____anova-oneway-test____
p.value = NULL
statistic = NULL
group <- factor(c(rep("con", length(eval(con1:con2))), rep("tre", length(eval(exp1:exp2)))))
dataframe=t(dataframe)
for(i in seq_len(ncol(dataframe))) {
  x = dataframe[,i]
  o = oneway.test(x~group)
  p.value[i] = o$p.value
  statistic[i] = o$statistic
}
dataframe=t(dataframe)
o_stat = cbind.data.frame(ID=row.names(dataframe),statistic,p.value)
o_stat$fdr[o_stat$p.value<=(alpha/nrow(o_stat))*seq_len(nrow(o_stat))] <- 1
write.csv(as.data.frame(na.omit(o_stat[o_stat$fdr == 1,-ncol(o_stat)])),
          "/var/www/DGEAR/csv/o_stat_significant.csv", row.names = F)


#######____Dunnett's test____
p.value = NULL
statistic = NULL
group = factor(c(rep("con",length(eval(con1:con2))),rep("tre",length(eval(exp1:exp2)))))
dataframe=t(dataframe)
for(i in seq_len(ncol(dataframe))) {
  x = dataframe[,i]
  d = DescTools::DunnettTest(x,group)
  p.value[i] = d$con[,4]
  statistic[i] = d$con[,1]
}
dataframe=t(dataframe)
d_stat = cbind.data.frame(ID=row.names(dataframe),statistic, p.value)
d_stat$fdr[d_stat$p.value<=(alpha/nrow(d_stat))*seq_len(nrow(d_stat))] <- 1
write.csv(as.data.frame(na.omit(d_stat[d_stat$fdr == 1,-ncol(d_stat)])),
          "/var/www/DGEAR/csv/d_stat_significant.csv", row.names = F)



#######____Half's t-test____
s0 = apply(con, 1, sd)
sample_size = sqrt((1/ncol(exp))+(1/ncol(con)))
half_t_stat = data.frame((exp_m-con_m)/(s0*sample_size))
colnames(half_t_stat)= "statistic"
for (i in seq_len(nrow(half_t_stat))) {
  half_t_stat$p.value = 2*pt(abs(half_t_stat$statistic), df=nrow(con)-1, lower.tail = F)
}
half_t_stat = cbind.data.frame(ID=row.names(dataframe),half_t_stat)
half_t_stat$fdr[half_t_stat$p.value<=(alpha/nrow(half_t_stat))*seq_len(nrow(half_t_stat))] <- 1
write.csv(as.data.frame(na.omit(half_t_stat[half_t_stat$fdr == 1,-ncol(half_t_stat)])),
          "/var/www/DGEAR/csv/half_t_stat_significant.csv", row.names = F)




#######____Wilcox/Mann-wheitneyU-test____
p.value = NULL
statistic = NULL
for(i in seq_len(nrow(dataframe))) {
  x = as.numeric(con[i,]) 
  y = as.numeric(exp[i,]) 
  u = wilcox.test(x, y, paired = F)
  p.value[i] = u$p.value
  statistic[i] = u$statistic
}

u_stat = cbind.data.frame(ID=row.names(dataframe),statistic,p.value)
u_stat$fdr[u_stat$p.value<=(alpha/nrow(u_stat))*seq_len(nrow(u_stat))] <- 1
write.csv(as.data.frame(na.omit(u_stat[u_stat$fdr == 1,-ncol(u_stat)])),
          "/var/www/DGEAR/csv/u_stat_significant.csv", row.names = F)




#########____ENSEMBL_____

df = cbind.data.frame(T_statistics = as.numeric(t_stat$fdr),
                      O_statistics = as.numeric(o_stat$fdr),
                      D_statistics = as.numeric(d_stat$fdr),
                      HT_statistics = as.numeric(half_t_stat$fdr),
                      U_statistics = as.numeric(u_stat$fdr))
row.names(df)= t_stat$ID
df[is.na(df)] <- 0
write.csv(row.names(df[rowSums(df) >= votting_cutoff,]),
          "/var/www/DGEAR/csv/ensembl_sigificant.csv", row.names = F)
df$mark <- ifelse(rowSums(df) >= votting_cutoff, 'significant', 'not')


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
dbs <- c("GO_Molecular_Function_2015", "GO_Cellular_Component_2015", "GO_Biological_Process_2015")
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
