### RBAC Admin Panel API

This project is a **Role-Based Access Control (RBAC) Admin Panel API** designed to manage roles, permissions, and user assignments with a secure system for auditing changes. The system allows admins and users with the proper permissions to manage user roles and permissions, ensuring accountability and security through permission checks at every level.

The API implements key features like **role management**, **permission management**, and **user role assignment** with specific permissions required to access each endpoint. It also supports **auditing**, where all changes made to roles, permissions, and user assignments are logged for tracking purposes.

### Key Features:
- **Role Management**: Create, update, and delete roles.
- **Permission Management**: Create permissions and assign them to roles.
- **User Role Assignment**: Assign roles to users with checks to prevent unauthorized actions.
- **Auditing**: Tracks all changes to roles, permissions, and assignments.
- **API Authentication**: Secured using **Laravel Passport** with permission-based access.

### Prerequisites

Before setting up the project, ensure you have the following installed:
- **PHP**
- **Composer** (PHP dependency manager)
- **Laravel**
- **PostgreSQL** (Database)

### Installation Instructions

#### Step 1: Install Dependencies

Run the following command to install all the required dependencies:

```bash
composer install
```

#### Step 2: Set Up Environment Variables

Create a copy of `.env.example` and rename it to `.env`:

```bash
cp .env.example .env
```

Modify the necessary fields in the `.env` file to set up your database connection and application URL:

```env
APP_URL=http://localhost:8000
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

#### Step 3: Run Database Migrations

Run the following command to migrate the database:

```bash
php artisan migrate
```

#### Step 4: Install Laravel Passport

Run the following command to install Passport, which is used for API authentication:

```bash
php artisan passport:install
```

### API Endpoints

#### 1. User Login

- **Endpoint**: `POST /api/login`
- **Description**: Logs in a user and returns an access token along with their roles and permissions.

**Request**:

```json
{
  "email": "admin@example.com",
  "password": "password123"
}
```

**Response**:

```json
{
  "access_token": "your_access_token",
  "token_type": "Bearer",
  "roles": ["admin"],
  "permissions": ["manage-roles", "manage-users", "manage-permissions"]
}
```

#### 2. Role Management (Requires `manage-roles` Permission)

These routes allow managing roles in the system. Only users with the `manage-roles` permission can access these endpoints.

- **Create Role**
  - **Endpoint**: `POST /api/roles`
  - **Description**: Creates a new role.

  **Request**:
  ```json
  {
    "name": "editor"
  }
  ```

  **Response**:
  ```json
  {
    "id": 1,
    "name": "editor",
    "created_at": "2024-09-25",
    "updated_at": "2024-09-25"
  }
  ```

- **Update Role**
  - **Endpoint**: `PUT /api/roles/{role}`
  - **Description**: Updates an existing role by its ID.

  **Request**:
  ```json
  {
    "name": "super-editor"
  }
  ```

  **Response**:
  ```json
  {
    "id": 1,
    "name": "super-editor",
    "updated_at": "2024-09-25"
  }
  ```

- **Delete Role**
  - **Endpoint**: `DELETE /api/roles/{role}`
  - **Description**: Deletes a role by its ID.

  **Response**:
  ```json
  {
    "message": "Role deleted successfully"
  }
  ```

#### 3. Permission Management (Requires `manage-permissions` Permission)

These routes allow creating and assigning permissions to roles.

- **Create Permission**
  - **Endpoint**: `POST /api/permissions`
  - **Description**: Creates a new permission in the system.

  **Request**:
  ```json
  {
    "name": "manage-articles"
  }
  ```

  **Response**:
  ```json
  {
    "id": 1,
    "name": "manage-articles",
    "created_at": "2024-09-25",
    "updated_at": "2024-09-25"
  }
  ```

- **Assign Permission to Role**
  - **Endpoint**: `POST /api/roles/assign-permission`
  - **Description**: Assigns a permission to a role.

  **Request**:
  ```json
  {
    "role_id": 1,
    "permission_id": 1
  }
  ```

  **Response**:
  ```json
  {
    "message": "Permission assigned to role successfully"
  }
  ```

#### 4. User Role Assignment (Requires `manage-users` Permission)

This route allows assigning roles to users, but only if the user has the `manage-users` permission.

- **Assign Role to User**
  - **Endpoint**: `POST /api/users/assign-role`
  - **Description**: Assigns a role to a user.

  **Request**:
  ```json
  {
    "user_id": 1,
    "role_id": 2
  }
  ```

  **Response**:
  ```json
  {
    "message": "Role assigned to user successfully"
  }
  ```

### Auditing and Accountability

All changes made through these endpoints—whether roles are created, updated, deleted, or assigned—are logged in the system for auditing purposes. This ensures that administrators can track who made changes and when they occurred.

### Conclusion

This RBAC Admin Panel API provides a robust solution for managing roles and permissions within an application. By leveraging Laravel Passport for secure authentication and a comprehensive permission system, it ensures that only authorized users can make changes, and that every change is audited for accountability.