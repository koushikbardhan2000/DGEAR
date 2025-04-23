#!/usr/bin/Rscript --vanilla

# Capture command-line arguments
args <- commandArgs(TRUE)
cols <- as.numeric(args[1])  # Number of points for histogram
fname <- args[2]             # File name without extension

# Define full path for the output image
output_path <- paste0("/var/www/html/webtool/test/", fname, ".png")

# Generate random data and plot histogram
png(filename=output_path, width=500, height=500)
hist(rnorm(cols, mean=0, sd=1), col="red", main="Generated Histogram")
dev.off()
