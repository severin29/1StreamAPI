# Stream Records API

## Overview

This API allows users to manage stream records, including creating, retrieving, updating, and deleting records. It also supports filtering and sorting.

## Base URL

```
http://1streamapi.test/api/
```

## Endpoints

### 1. Get All Stream Records (With Filtering & Sorting)

**Endpoint:**

```
GET /records
```

**Query Parameters:**

| Parameter       | Type   | Description                                                |
| --------------- | ------ | ---------------------------------------------------------- |
| title           | string | Filter by title (case-insensitive)                         |
| type            | int    | Filter by stream type ID                                   |
| min\_price      | int    | Filter by minimum token price                              |
| max\_price      | int    | Filter by maximum token price                              |
| expires\_before | date   | Filter by expiration date before a given date (YYYY-MM-DD) |
| expires\_after  | date   | Filter by expiration date after a given date (YYYY-MM-DD)  |
| sort\_by        | string | Sort by `tokens_price` or `date_expiration`                |
| sort\_order     | string | Sorting direction (`asc` or `desc`)                        |
| per\_page       | int    | Number of records per page                                 |
| page            | int    | Page number                                                |

**Example Request:**

```
GET /records?title=podcast&type=2&min_price=100&expires_before=2025-12-31&sort_by=tokens_price&sort_order=desc&per_page=5&page=1
```

**Response:**

```json
{
    "current_page": 1,
    "data": [...],
    "total": 15,
    "per_page": 5,
    "last_page": 3,
    "next_page_url": "http://1streamapi.test/api/records?page=2"
}
```

### 2. Get a Single Stream Record

**Endpoint:**

```
GET /records/{id}
```

**Example:**

```
GET /records/1
```

**Response:**

```json
{
    "id": 1,
    "title": "Sports Match",
    "description": "Recording of the sports match",
    "tokens_price": 500,
    "type": 1,
    "date_expiration": "2025-12-31 23:59:59"
}
```

### 3. Create a Stream Record

**Endpoint:**

```
POST /records
```

**Request Body:**

```json
{
    "title": "New Stream",
    "description": "Stream description",
    "tokens_price": 250,
    "type": 3,
    "date_expiration": "2025-12-31 23:59:59"
}
```

**Response:**

```json
{
    "message": "Record created",
    "data": {...}
}
```

### 4. Update a Stream Record

**Endpoint:**

```
PUT /records/{id}
```

**Request Body:** (Only send fields you want to update)

```json
{
    "title": "Updated Title"
}
```

**Response:**

```json
{
    "message": "Record updated",
    "data": {...}
}
```

### 5. Delete a Stream Record

**Endpoint:**

```
DELETE /records/{id}
```

**Response:**

```json
{
    "message": "Record deleted"
}
```

## Pagination

- Default: **10 records per page**
- Customize with `per_page` and `page` parameters

## Sorting

- Use `sort_by=tokens_price` or `sort_by=date_expiration`
- Default: Ascending (`asc`), but can specify `sort_order=desc`

## Filtering

- Case-insensitive title search
- Date range filtering (`expires_before`, `expires_after`)
- Token price range filtering (`min_price`, `max_price`)

## Setup Instructions

1. Clone the repository
2. Install dependencies:
   ```sh
   composer install
   ```
3. Set up the database:
   ```sh
   php artisan migrate --seed
   ```
4. Run the application:
   ```sh
   php artisan serve
   ```

