#!/usr/bin/Rscript --vanilla
setwd("C:/xampp/htdocs/webtool")
args <- commandArgs(TRUE)
cols <- args[1]
fname <- args[2]
x <- rnorm(cols,0,1)
fname = paste(fname, "png", sep = ".")
png(filename=fname, width=500, height=500)
hist(x, col="red")
dev.off()
#Terminal script: "C:/Program Files/R/R-4.2.0/bin/x64/Rscript.exe" "C:/xampp/htdocs/webtool/temp.R" 6 "temp"
