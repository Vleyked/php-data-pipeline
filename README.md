# Set up

- Create a service account with GoogleSheets access and Bigquery Owner or (Bigquery jobs user and Bigquery Data admin)
- Creake a key file called bigquery.json and move it to src folder.
- Install docker if you do not have it
- Create a bigquery dataset with the following schema

```
          
      
| Column   |  Type  |
|----------|:--------:|
| location | STRING | 
| date     | STRING | 
| dawn     | STRING | 
| dusk     | STRING |   
| sunrise  | STRING |  
| sunset   | STRING | 

```

- Modify inserRows.php with your project data
  32 'projectId' => 'your-project-id'
  64 $places = get_places('./credentials.json', 'your-google-sheet-id');
  65 $response = get_daily_times($places, 'date you want to start with');
  76 table_insert_rows_explicit_none_insert_ids('yout-dataset-id', 'yout-table-id', $new_row);
- docker build -t php8.2-ubuntu .

Your docker will load php-cli image and execute the 3 month load to your table-id in bigquery
