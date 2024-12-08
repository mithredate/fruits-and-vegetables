# Fruits and Vegetables Service

This project implements a service that processes a JSON file, categorizes items into Fruits and Vegetables, and provides functionalities to add, remove, list, and query these collections. The service also includes API endpoints for interaction with the collections.

---

## 🎯 Goals

1. **Process JSON Input**:
    - Parse the `request.json` file to categorize items into two collections: `Fruits` and `Vegetables`.
    - Store items in units of grams.
    - This is only accessible in tests `\App\Tests\Integration\Service\StorageServiceTest`
    - Tests store the collection in an in-memory Sqlite DB using Doctrine

2. **Collections Functionality**:
    - Is immutable to prevent issues with concurrent writes
    - Provide methods for each collection:
        - `add(item)`
        - `set(index, item)`
        - `remove(index)`
        - `has(index)`
        - `get(index)`
        - `isEmpty`
        - `count`
        - `filter(criteria)`
        - `first(criteria)`
        - `map(callback)`
        - `forEach(callback)`
    - Is array access (read-only)
    - Is iterable to be used in foreach loops

3. **Storage**:
    - Store the collections using sqlite database using Doctrine.

4. **API Endpoints**:
    Two API endpoints have been created for `fruits` and `vegetables`, both as a REST resource.
   - The `fruits` collection (`api/v1/fruits`) has most useful REST actions (`index`, `store`, `show`, `update`, and `delete`)
   - The `vegetables` collection (`api/v1/vegetables`) has only `index` and `show` (lack of time)
   - The `fruits` index can be searched by `search` parameter (searched in the name). Ex: `api/v1/fruits?search=app
   - The `fruits` index and show can be configured to show quantities in `g` or `kg`. Ex: `api/v1/fruits?unit=kg



## 🛠️ Setup Instructions

1. **Clone the repository**:
   ```bash
   git clone <repository-url>
   cd <repository-directory>
2. **Install Dependencies**
    ```bash
   composer install
    ```
3. **Seed Testing Data**
    ```bash
   php bin/console doctrine:fixtures:load
    ```
4. **Run the application**
   ```bash
   symfony server:start
   ```
---

## 🚀 Usage

### Retrieving fruits/vegetables list with search and specific units
```bash
curl --location 'http://localhost:8000/api/v1/fruits?unit=kg&search=app&unit=kg' \
curl --location 'http://localhost:8000/api/v1/vegetables'
```

### Retrieve specific fruit
```bash
curl --location 'http://localhost:8000/api/v1/fruits/3?unit=kg'
```

### Create a new fruit
```bash
curl --location 'http://localhost:8000/api/v1/fruits' \
--header 'Content-Type: application/json' \
--data '{
    "name": "Banana",
    "quantity": 2,
    "unit": "kg"
}'
```

### Update fruit
```bash
curl --location --request PUT 'http://localhost:8000/api/v1/fruits/3' \
--header 'Content-Type: application/json' \
--data '{
    "name": "Banana",
    "quantity": 340,
    "unit": "g"
}'
```

### Delete fruit
```bash
curl --location --request DELETE 'http://localhost:8000/api/v1/fruits/3'
```
