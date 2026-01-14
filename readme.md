# Campus Selection Decision Support System Using WSM Method (CodeIgniter)

This project is a **Decision Support System (DSS)** built using **CodeIgniter (PHP Framework)** and **Cuba Admin Template** to assist users in selecting the most suitable **private university (kampus swasta)** using the **Weighted Sum Model (WSM)** method.

---

## Features

### 1. Alternative (Campus) Data Input

- Input campus/university name
- Input alternative values for each criterion
- Form validation to ensure data completeness
- Clean and responsive form layout using Bootstrap (Cuba Admin)

### 2. Criteria Management

- Manage evaluation criteria dynamically
- Each criterion includes:
  - Criterion name
  - Weight value
  - Type (Benefit or Cost)
- Criteria weights are used directly in WSM calculation
- Supports modification of criteria without changing calculation logic

### 3. WSM Calculation

- Normalization method:
  - **Benefit**:
    ```
    normalized_value = value / max_value
    ```
  - **Cost**:
    ```
    normalized_value = min_value / value
    ```
- Weight normalization:
  ```
  normalized_weight = weight / total_weight
  ```
- Final preference value formula:

\[
S*i = \sum (r*{ij} \times w_j^{normalized})
\]

- Automatically calculates preference values for all alternatives

### 4. Ranking Results

- Displays ranking results from highest to lowest preference value
- Shows:
- Preference score (0.xxx format)
- Ranking position
- Alternative (campus) name
- Clear and structured ranking table

### 5. Dashboard Interface

- Dashboard overview with navigation cards:
- Input Campus Data
- Manage Criteria
- View Ranking Results
- Responsive layout with sidebar navigation
- Consistent UI using Cuba Admin Template

---

## Technologies Used

- PHP (CodeIgniter Framework)
- MySQL (Database)
- Bootstrap 5 (Cuba Admin Template)
- JavaScript & jQuery
- Feather Icons & FontAwesome

---

## Methodology

This system uses the **Weighted Sum Model (WSM)**, a simple yet effective Multi-Criteria Decision Making (MCDM) method suitable for ranking alternatives based on multiple weighted criteria.

---

## Notes

- This project focuses on **clarity, modularity, and ease of extension**
- Additional criteria or alternatives can be added without modifying the core calculation logic
- Suitable for academic research, final projects, or decision-support case studies

---
