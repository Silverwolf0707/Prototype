import pandas as pd
from statsmodels.tsa.seasonal import STL
import json

# Read the grouped CSV
csv_path = r'C:\xampp\htdocs\test_web_app\storage\app\public\patient_records.csv'
df = pd.read_csv(csv_path, parse_dates=['month'])

# Ensure all categories have consistent monthly timeline (fill missing months)
all_months = pd.date_range(start=df['month'].min(), end=df['month'].max(), freq='MS')
categories = df['case_category'].unique()

output = {}

for cat in categories:
    cat_df = df[df['case_category'] == cat].set_index('month').sort_index()
    cat_series = cat_df['value'].reindex(all_months, fill_value=0)  # fill gaps

    stl = STL(cat_series, period=12)
    result = stl.fit()

    output[cat] = {
        'dates': all_months.strftime('%Y-%m').tolist(),
        'observed': cat_series.round(2).tolist(),
        'trend': result.trend.round(2).tolist(),
        'seasonal': result.seasonal.round(2).tolist(),
        'residual': result.resid.round(2).tolist()
    }

# Save result per case category
json_path = r'C:\xampp\htdocs\test_web_app\storage\app\public\stl_output.json'
with open(json_path, 'w') as f:
    json.dump(output, f)
