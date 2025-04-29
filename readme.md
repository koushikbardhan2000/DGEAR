# DGEAR-Web Dashboard Manual

## Table of Contents

- [Differential Gene Expression Analysis Resource (DGEAR)](#differential-gene-expression-analysis-resource-dgear)
  - [Introduction](#introduction)
  - [Architecture Overview](#architecture-overview)
  - [Key Features](#key-features)
  - [Data Format and Example Data](#data-format-and-example-data)
    - [1. Microarray Example Data](#1-microarray-example-data)
    - [2. RNA-seq Example Data](#2-rna-seq-example-data)
- [User Manual](#user-manual)
  - [1. Opening the Web Tool](#1-opening-the-web-tool)
  - [2. Navigation](#2-navigation)
  - [3. Uploading Data](#3-uploading-data)
  - [4. Setting Input Parameters](#4-setting-input-parameters)
  - [5. Submitting and Processing the Request](#5-submitting-and-processing-the-request)
  - [6. Exploring Results](#6-exploring-results)
- [DGEAR Algorithm](#dgear-algorithm)
- [Important Notes](#important-notes)
- [Project Background](#project-background)
- [Support](#support)

---

## Differential Gene Expression Analysis Resource (DGEAR)

### Introduction

Welcome to DGEAR-Web, an intuitive web-based platform for ensemble-based differential gene expression analysis. DGEAR empowers researchers, scientists, and users from varied backgrounds to perform complex DEG (Differentially Expressed Genes) predictions from gene expression data through a user-friendly, GUI-driven environment.

### Architecture Overview

DGEAR-Web is designed with the following key principles:

- **Cross-Platform Compatibility**: Accessible across Windows, macOS, Linux, and mobile devices through any modern web browser.
- **User-Friendly Interface**: Easy-to-navigate graphical interface with buttons, forms, and menus, ensuring usability without prior programming knowledge.
- **Accessibility**: Opens up bioinformatics analysis to users with minimal technical expertise.
- **Efficiency and Time-Saving**: Streamlined workflows minimize manual intervention, speeding up the data preprocessing and analysis process.

### Key Features

- Upload and analyze gene expression data via simple file upload.
- Customizable input parameters: define control/experimental groups, significance level (alpha), and ensemble voting cutoff.
- Visual outputs: generate plots, results summaries, and downloadable data.
- Result exploration: interactive browsing and download options for outputs.

### Data Format and Example Data

- Ensure your data is formatted correctly before upload.
- Example data files are available on the website.

#### 1. Microarray Example Data

| ID     | GSM388076 | GSM388077 | GSM388078 | GSM388079 |
|--------|-----------|-----------|-----------|-----------|
| A1BG   | 4.993423  | 4.977204  | 5.69549   | 5.876676  |
| A1CF   | 4.788285  | 4.417162  | 7.557621  | 7.662921  |
| A2M    | 4.522844  | 4.679698  | 5.842635  | 5.939148  |
| A2ML1  | 3.864138  | 3.771948  | 4.234489  | 4.342140  |
| A4GALT | 6.248286  | 6.375555  | 7.616046  | 7.489524  |
| ...    | ...       | ...       | ...       | ...       |

#### 2. RNA-seq Example Data

| GeneID     | GSM8279311 | GSM8279313 | GSM8279314 | GSM8279315 |
|------------|------------|------------|------------|------------|
| 100287102  | 3          | 3          | 3          | 1          |
| 653635     | 367        | 333        | 249        | 277        |
| 102466751  | 9          | 12         | 4          | 10         |
| 107985730  | 1          | 1          | 0          | 0          |
| 100302278  | 0          | 0          | 0          | 0          |
| ...        | ...        | ...        | ...        | ...        |

---

## User Manual

### 1. Opening the Web Tool

- Visit [https://compbiosysnbu.in/DGEAR/](https://compbiosysnbu.in/DGEAR/)
- The landing page offers an overview and navigation guidance.

### 2. Navigation

- Use the navigation panel at the top or bottom.
- Sections include:
  - Home
  - Analysis
  - Results
  - Contact

### 3. Uploading Data

- Go to the **Analysis** tab.
- Choose Microarray or RNA-seq analysis.
- Drag and drop or click to upload your file (.tsv, .txt).

### 4. Setting Input Parameters

- After upload, configure:
  - **Compare Column Range**: e.g., for 4 samples comparing 2 vs 2 → Control: 1–2, Experiment: 3–4
  - **Alpha Value**: significance threshold, e.g., 0.05
  - **Voting Cutoff**: number of methods that must agree a gene is differentially expressed
    - Microarray: 1–5
    - RNA-seq: 1–3

### 5. Submitting and Processing the Request

- Click **Submit Request**.
- Data will be processed using the ensemble framework.

### 6. Exploring Results

- Once complete, visit the **Results Page** to:
  - View summary plots (e.g., Volcano, MA plots)
  - Download DEG lists and other outputs

---

## DGEAR Algorithm

DGEAR implements an ensemble model with a modified majority voting algorithm.

- **Microarray**:
  - Statistical tests: Student’s t-test, ANOVA, Dunnett’s t-test, half t-test, Wilcoxon/Mann-Whitney U-test
- **RNA-seq**:
  - Methods: Linear modeling, negative binomial modeling, empirical Bayes

After FDR correction, results from individual tests are converted to logical vectors, combined via majority voting to determine DEGs.

---

## Important Notes

- Format: genes as rows, samples as columns
- Set input parameters according to your experimental design
- Internet connection is required

---

## Project Background

DGEAR-Web was developed under the academic project titled:

> "To Develop an Ensemble Framework for Differential Expression Analysis"

Submitted to the University of North Bengal for the degree of M.Sc. in Bioinformatics by **Koushik Bardhan** (Batch: 2022–2023) under the guidance of **Dr. Chiranjib Sarkar**, Department of Bioinformatics.

---

## Support

For issues or suggestions, contact the project team through the communication options provided on the DGEAR-Web platform.

---

**Happy Researching with DGEAR-Web!**