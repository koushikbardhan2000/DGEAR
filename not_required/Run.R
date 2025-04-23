#######____Main____
dataframe <- data.frame(
  read.delim(file.choose()))
con1 = as.numeric(readline(prompt = "Enter control start column : "))
con2 = as.numeric(readline(prompt = "Enter control end column : "))
exp1 = as.numeric(readline(prompt = "Enter experiment start column : "))
exp2 = as.numeric(readline(prompt = "Enter experimrnt end column : "))
con= dataframe[,eval(con1:con2)]
exp= dataframe[,eval(exp1:exp2)]
con_m = rowMeans(con)
exp_m = rowMeans(exp)
alpha = as.numeric(readline(prompt = "Specify Alpha value : "))
votting_cutoff = as.numeric(
  readline(prompt = "Specify votting cutoff(not morethan 5) : "))
#########____FC____
abs_FC = abs(exp_m - con_m)
log2FC = log2((exp_m - con_m))
relative_log2FC = as.data.frame(log2(((exp_m/con_m)-1)))



#######____t-test____
p.value = NULL
statistic = NULL 
for(i in 1 : nrow(dataframe)) {
  x = con[i,] 
  y = exp[i,] 
  t = t.test(x, y)
  p.value[i] = t$p.value
  statistic[i] = t$statistic
}

t_stat = cbind.data.frame(ID=row.names(dataframe),p.value,statistic)
t_stat$fdr[t_stat$p.value<=(alpha/nrow(t_stat))*seq(length=nrow(t_stat))] <- 1
write.csv(as.data.frame(na.omit(t_stat[t_stat$fdr == 1,])),
          "t_stat_significant.csv", row.names = F)


#######____anova-oneway-test____
p.value = NULL
statistic = NULL
group = factor(c(rep("con",length(eval(con1:con2))),rep("tre",length(eval(exp1:exp2)))))
dataframe=t(dataframe)
for(i in 1 : ncol(dataframe)) {
  x = dataframe[,i]
  o = oneway.test(x~group)
  p.value[i] = o$p.value
  statistic[i] = o$statistic
}
dataframe=t(dataframe)
o_stat = cbind.data.frame(ID=row.names(dataframe),p.value,statistic)
o_stat$fdr[o_stat$p.value<=(alpha/nrow(o_stat))*seq(length=nrow(o_stat))] <- 1
write.csv(as.data.frame(na.omit(o_stat[o_stat$fdr == 1,])),
          "o_stat_significant.csv", row.names = F)


#######____Dunnett's test____
library(DescTools)
p.value = NULL
statistic = NULL
group = factor(c(rep("con",length(eval(con1:con2))),rep("tre",length(eval(exp1:exp2)))))
dataframe=t(dataframe)
for(i in 1 : ncol(dataframe)) {
  x = dataframe[,i]
  d = DunnettTest(x,group)
  p.value[i] = d$con[,4]
  
}
dataframe=t(dataframe)
d_stat = cbind.data.frame(ID=row.names(dataframe),p.value)
d_stat$fdr[d_stat$p.value<=(alpha/nrow(d_stat))*seq(length=nrow(d_stat))] <- 1
write.csv(as.data.frame(na.omit(d_stat[d_stat$fdr == 1,])),
          "d_stat_significant.csv", row.names = F)



#######____Half's t-test____
s0 = apply(con, 1, sd)
sample_size = sqrt((1/ncol(exp))+(1/ncol(con)))
half_t_stat = data.frame((exp_m-con_m)/(s0*sample_size))
colnames(half_t_stat)= "statistic"
for (i in 1:nrow(half_t_stat)) {
  half_t_stat$p.value = 2*pt(abs(half_t_stat$statistic), df=nrow(con)-1, lower.tail = F)
}
half_t_stat$fdr[half_t_stat$p.value<=(alpha/nrow(half_t_stat))*seq(length=nrow(half_t_stat))] <- 1
write.csv(as.data.frame(na.omit(half_t_stat[half_t_stat$fdr == 1,])),
          "half_t_stat_significant.csv", row.names = F)




#######____Wilcox/Mann-wheitneyU-test____
p.value = NULL
statistic = NULL 
for(i in 1 : nrow(dataframe)) {
  x = as.numeric(con[i,]) 
  y = as.numeric(exp[i,]) 
  u = wilcox.test(x, y, paired = F)
  p.value[i] = u$p.value
  statistic[i] = u$statistic
}

u_stat = cbind.data.frame(ID=row.names(dataframe),p.value,statistic)
u_stat$fdr[u_stat$p.value<=(alpha/nrow(u_stat))*seq(length=nrow(u_stat))] <- 1
write.csv(as.data.frame(na.omit(u_stat[u_stat$fdr == 1,])),
          "u_stat_significant.csv", row.names = F)




######### ____ENSEMBL_____

df = cbind.data.frame(as.numeric(t_stat$fdr),
                      as.numeric(o_stat$fdr),
                      as.numeric(d_stat$fdr),
                      as.numeric(half_t_stat$fdr),
                      as.numeric(u_stat$fdr))
row.names(df)= t_stat$ID
df[is.na(df)] <- 0
write.csv(row.names(df[rowSums(df) >= votting_cutoff,]),"ensembl_sigificant.csv", row.names = F, col.names = "Gene_symbol")
df$mark <- ifelse(rowSums(df) >= votting_cutoff, 'significant', 'not')
View(df)


######### ____HeatMap____
ensembl_significant = as.data.frame(dataframe[df$mark =="significant",])


ensembl_significant <- scale(ensembl_significant)
heatmap(ensembl_significant,
        cexRow =0.7,#font size of rows
        cexCol = 1,#font size of columns
        main = "Heatmap_",
        xlab = "Samples", ylab = "Gene_Symbols")

