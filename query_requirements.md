# GUI / query requirements

## 1. INSERT
- [x] The user should be able to specify what values to insert
  - input values for the fields in the Animal, VetAppointment, AnimalCaretaker, Worker, Volunteer, FundraiserEvent, SocialMediaPost, Customer, Adopter, Adoption, Appointment, Donation, Item, and Purchase tables.
- [x] The insert operation should affect more than one table (i.e., an insert should occur on a table with a foreign key)
  - implement this so insert of data updates all of the related tables when we have foreign key relationship.
- [x] The chosen query and table(s) should make sense given the context of the application. 
- [ ] The INSERT operation should be able to handle the case where the foreign key value in the tuple does not exist in the table that is being referred to.
  - application handles cases where a foreign key value in the tuple does not exist in the referred table.
- [x] The tables that the insert operation will run on can be pre-chosen by the group. 

## 2. DELETE
- [x] Implement a cascade-on-delete situation (or an alternative that was agreed to by the TA if the DB system doesn’t provide this). The user should be able to choose what values to delete. 
- [x] The tables that the delete operation will run on can be chosen by the group. 
- [x] The chosen query and table(s) should make sense given the context of the application. 

## 3. UPDATE
- [x] The user should be able to update any number of non-primary key attributes in a relation. 
- [x] The relation used for the update operation must have at least two non-primary key attributes. At least one non-primary key attribute must have either a UNIQUE constraint or be a foreign key that references another table. 
- [x] The application should present the tuples that are available so that the user can select which tuple they want to update. 
- [x] The chosen query and table(s) should make sense given the context of the application. 

## 4. Selection
- [x] The user is able to specify the filtering conditions for a given table. That is, the user is able to determine what shows up in the WHERE clause. 
- [x] The user should be allowed to search for tuples using any number of AND/OR clauses. 
- [x] The group can choose which table to run this query on. The query and chosen table(s) should make sense given the context of the application. 

## 5. Projection
- [x] The user is able to choose any number of attributes to view from any relation in the database. Non-selected attributes must not appear in the result. 
- [x] One or more tables in the relation must contain at least four attributes. 
- [x] The application must dynamically load the tables from the database (i.e., if we were to insert a new table in the database at the start of the demo, this new table should also show up as a possible option to project from). 
- [x] You do not have to allow projection over multiple relations. Projecting over individual relations is sufficient for this rubric item. 

## 6. Join
- [x] Create one query in this category, which joins at least 2 tables and performs a meaningful query, and provide an interface for the user to execute this query. 
- [x] The user must provide at least one value to qualify in the WHERE clause (e.g. join the Customer and the Transaction table to find the names and phone numbers of all customers who have purchased a specific item).  
- [x] The group can choose which tables will be affected by the query.  
- [x] The query and chosen table(s) should make sense given the context of the application. 

## 7. Aggregation with GROUP BY
- [x] Create one query that requires the use of aggregation (min, max, average, or count are all fine), and provide an interface (e.g., HTML button/dropdown, etc.) for the user to execute this query.  
- [x] The group can choose which table to run this query on. 
- [x] The schema can be statically set but the tuples used in the query cannot be predetermined.  
For example, you can specify that you want to find the total revenue per month but you cannot hardcode which exact months will be in the answer. If the TA asks to add in a sale for a new month, then that new month must be included in the returned results. 
- [x] The query and chosen table(s) should make sense given the context of the application. 

## 8. Aggregation with HAVING
- [x] Create one meaningful query that requires the use of a HAVING clause, and provide an interface (e.g., HTML button/dropdown, etc.) for the user to execute this query. 
The schema can be statically set but the tuples used in the query cannot be predetermined. 
- [x] The query and chosen table(s) should make sense given the context of the application. 

## 9. Nested Aggregation with GROUP BY
- [x] Create one query that finds some aggregated value for each group (e.g., use a nested subquery, such as finding the average number of items purchased per customer,
subject to some constraint). Some examples for the Sailors table are given in the project specs. 
- [x] The schema can be statically set but the tuples used in the query cannot be predetermined. 
Note the difference between this query and the above Aggregation Query. You must use separate distinct queries for this criterion and the Aggregation Query (i.e., do not double dip). 
It is fine to use a view to get the desired behaviour. 
- [x] The query and chosen table(s) should make sense given the context of the application. 

## 10. Division
- [x] Create one query of this category and provide an interface (i.e., HTML button, etc.) for the user to execute this query (e.g., find all the customers who bought all the items). 
- [x] The schema can be statically set but the tuples used in the query cannot be predetermined. For example, you can specify that division will happen between this relation with x attributes and that relation with y attributes but the actual values used in the division operation should be dynamic. 
- [x] The query and chosen table(s) should make sense given the context of the application.
