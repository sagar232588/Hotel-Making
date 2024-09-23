import pandas as pd
import mysql.connector
from surprise import Dataset, Reader, SVD
from surprise.model_selection import train_test_split, accuracy

# Step 1: Establish a connection to your MySQL database
conn = mysql.connector.connect(
    host="localhost",         # Replace with your host (e.g., localhost)
    user="root",     # Replace with your MySQL username
    password="", # Replace with your MySQL password
    database="hotel_db"  # Your database name
)

# Step 2: Query the data from your database (modify query as per your table structure)
query = """
SELECT user_id, hotel_id, rating
FROM hotel_reviews
"""
data = pd.read_sql(query, conn)

# Step 3: Close the database connection
conn.close()

# Step 4: Prepare data for collaborative filtering using scikit-surprise
reader = Reader(rating_scale=(1, 5))
surprise_data = Dataset.load_from_df(data[['user_id', 'hotel_id', 'rating']], reader)

# Step 5: Train-test split
trainset, testset = train_test_split(surprise_data, test_size=0.2, random_state=42)

# Step 6: Train the model using the SVD algorithm
algo = SVD()
algo.fit(trainset)

# Step 7: Evaluate the model
predictions = algo.test(testset)
accuracy.rmse(predictions)
accuracy.mae(predictions)
