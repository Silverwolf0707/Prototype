# stl_analysis.py
import pandas as pd
from statsmodels.tsa.seasonal import STL
import json

# Path to CSV exported by Laravel
csv_path = r'C:\xampp\htdocs\test_web_app\storage\app\public\patient_records.csv'

# Read CSV
df = pd.read_csv(csv_path, parse_dates=['date_processed'])

# Aggregate monthly counts
monthly = df.resample('M', on='date_processed').size().rename('value')

# Perform STL decomposition (period=12 for monthly seasonality)
stl = STL(monthly, period=12)
result = stl.fit()

# Prepare JSON data: date labels + components (trend, seasonal, resid)
output = {
    'dates': monthly.index.strftime('%Y-%m').tolist(),
    'trend': result.trend.round(2).tolist(),
    'seasonal': result.seasonal.round(2).tolist(),
    'residual': result.resid.round(2).tolist(),
    'observed': monthly.round(2).tolist()
}

# Save to JSON file in Laravel storage
json_path = r'C:\xampp\htdocs\test_web_app\storage\app\public\stl_output.json'
with open(json_path, 'w') as f:
    json.dump(output, f)
