# Employee Management API

## Week 3 - API Design and Documentation

### 1. API Title

Employee Management API

### 2. API Description

The Employee Management API is a RESTful API designed to manage employee information. It allows users to view, add, update, delete, search, and filter employee records.

### 3. Base URL

http://127.0.0.1:8000/api/v1

### 4. API Version

Version: v1

The API uses versioning to allow future improvements without breaking existing applications.

Example:

/api/v1/employees

Future versions may use:

/api/v2/employees

### 5. API Resources

The main resources of the system are:

- employees
- departments

Resource names use nouns and plural forms because they represent collections of data.

### 6. Employee Endpoints

| HTTP Method | Endpoint | Description |
|-------------|----------|-------------|
| GET | /employees | View all employees |
| GET | /employees/{id} | View one employee |
| POST | /employees | Add a new employee |
| PUT | /employees/{id} | Update employee information |
| DELETE | /employees/{id} | Delete an employee |
| GET | /employees?search=juan | Search employee by name |
| GET | /employees?department_id=1 | Filter employees by department |

### 7. CRUD Operations

| CRUD Operation | HTTP Method | Endpoint |
|----------------|-------------|----------|
| Create | POST | /employees |
| Read All | GET | /employees |
| Read One | GET | /employees/{id} |
| Update | PUT | /employees/{id} |
| Delete | DELETE | /employees/{id} |

### 8. Sample POST Request

Endpoint:

POST /api/v1/employees

Request Body:

```json
{
    "first_name": "Juan",
    "last_name": "Dela Cruz",
    "email": "juan@example.com",
    "department": "IT",
    "position": "Programmer"
}