<?php

namespace core\DataBase;

use traits\Logger\Logger;

class Database
{

    use Logger;

    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $DB = "Ecommerce_Store_2";

    public $conn;

    private $sqlUser = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
    ";

    private $sqlAdmin = "CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('super_admin', 'manager', 'staff') DEFAULT 'staff',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
    ";

    private $sqlCategories = "CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
    ";

    private $sqlProduct = "CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(200) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    image VARCHAR(255),
    published TINYINT(1) DEFAULT 1, -- 1 = published, 0 = unpublished
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);
";


    private $sqlShippingMethod = "CREATE TABLE IF NOT EXISTS shipping_methods (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    cost DECIMAL(10,2) NOT NULL,
    estimated_days INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
    ";

    private $sqlPayment = "CREATE TABLE IF NOT EXISTS payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    method ENUM('paypal', 'stripe', 'cod') NOT NULL,
    transaction_id VARCHAR(255),
    amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'completed', 'failed', 'refunded') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
    ";




    private $sqlOrders = "CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    shipping_id INT NOT NULL,
    payment_id INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (shipping_id) REFERENCES shipping_methods(id),
    FOREIGN KEY (payment_id) REFERENCES payments(id) 
    );
    ";

    private $sqlOrderitems = "CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id)
    );
    ";

    private $sqlCart = "CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
    );
    ";

    private $sqlLogs = "CREATE TABLE IF NOT EXISTS logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT,
    action VARCHAR(255) NOT NULL,
    ip_address VARCHAR(50),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES admins(id) ON DELETE SET NULL
    );
    ";



    private static $instance = null;

    function __construct()
    {
        $this->connect();
        $sql = "CREATE DATABASE IF NOT EXISTS $this->DB";
        $this->create_Connect_DB($sql);
        $this->create_Table($this->sqlUser);
        $this->create_Table($this->sqlAdmin);
        $this->create_Table($this->sqlCategories);
        $this->create_Table($this->sqlProduct);
        $this->create_Table($this->sqlShippingMethod);
        $this->create_Table($this->sqlPayment);
        $this->create_Table($this->sqlOrders);
        $this->create_Table($this->sqlOrderitems);
        $this->create_Table($this->sqlCart);
        $this->create_Table($this->sqlLogs);
    }


    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    function connect()
    {
        $this->conn = new \mysqli($this->servername, $this->username, $this->password);

        if ($this->conn->connect_error) {
            die("Connection Failed: " . $this->conn->connect_error);
            $this->logmessage("Connection Failed: " . $this->conn->connect_error);
        }

        return $this->conn;
    }


    function query_Executor($sql_Query, $parameters = [])
    {
        if (!empty($parameters)) {
            // $placeHolders = implode(", ", array_fill(0, count($parameters), '?'));


            $types = '';
            $values = [];

            foreach ($parameters as $value) {
                $types .= match (gettype($value)) {
                    'integer' => 'i',
                    'double' => 'd',
                    default => 's',
                };
                $values[] = $value;
            }

            $stmt = $this->conn->prepare($sql_Query);

            if (!$stmt) {
                // die("Prepare Failed : " . $this->conn->error);
                $this->logmessage("Prepare Failed : " . $this->conn->error);
            }

            $stmt->bind_param($types, ...$values);

            $executed = $stmt->execute();


            // return $executed;
            if (!$executed) {
                $this->logmessage("Error Executing query : " . $sql_Query);
                return [];
            }
            $this->logmessage("$sql_Query :" . ("Executed" . $sql_Query . " "));
            $result = $stmt->get_result();
            $data = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
            $stmt->close();

            return $data;
        } else {
            $result = $this->conn->query($sql_Query);
            if ($result) {
                $this->logmessage("$sql_Query : Executed ");
                $data = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];


                return $data;
                // return $result;
            } else {
                $this->logmessage("Error Executing query : " . $sql_Query . " ");
                return [];
            }
        }
    }

    function create_Connect_DB(string $sql)
    {
        if ($this->conn->query($sql) === true) {
            $this->logmessage("Database '$this->DB' created or already exists");
            $this->conn->select_db($this->DB);
        } else {
            $this->logmessage("Error creating database : " . $this->conn->error . "");
        }
    }

    function create_Table(string $sql)
    {
        if ($this->conn->query($sql) === true) {
            $this->logmessage("Database tables created or already exists");
        } else {
            $this->logmessage("Error creating table : " . $this->conn->error . "");
        }
    }

    function insert_Data(array $data, string $table, $conditions = [], int $option)
    {
        $columns = implode(", ", array_keys($data));
        $placeHolders = implode(", ", array_fill(0, count($data), '?'));

        $spec_column = implode("", array_keys($conditions));
        $spec_col_value = implode("", $conditions);

        $insert_sql = "INSERT INTO $table ($columns) VALUES ($placeHolders);";

        $select_Sql = "SELECT $columns FROM $table";

        $check_sql  = "SELECT $columns FROM $table WHERE $spec_column = '$spec_col_value';";

        $types = '';
        $values = [];

        foreach ($data as $value) {
            $types .= match (gettype($value)) {
                'integer' => 'i',
                'double' => 'd',
                default => 's',
            };
            $values[] = $value;
        }


        if ($option == 1) {

            $stmt = $this->conn->prepare($insert_sql);

            if (!$stmt) {
                die("Prepare Failed : " . $this->conn->error);
                $this->logmessage("Prepare Failed : " . $this->conn->error);
            }

            $stmt->bind_param($types, ...$values);

            $executed = $stmt->execute();
            $this->logmessage("Query executed: " . ($executed ? "Success" : "Fail"));

            return $executed;
        } elseif ($option == 2) {
            $result = $this->conn->query($check_sql);
            // echo "result reached\n";

            // $row = $result->fetch_assoc();

            // echo 
            if ($result && $result->num_rows == 0) {
                // echo "result true\n";
                $stmt = $this->conn->prepare($insert_sql);

                if (!$stmt) {
                    // die("Prepare Failed : " . $this->conn->error);
                    $this->logmessage("Prepare Failed : " . $this->conn->error);
                    // echo "stmt failed\n";
                }

                $stmt->bind_param($types, ...$values);

                // echo "stmt param binded\n";

                $success = $stmt->execute();

                if ($success) {
                    $this->logmessage("Data inserted in $table ....");
                    return true;
                } else {
                    $this->logmessage("Data cannot be inserted $table ....");
                    return false;
                }
            } else {
                $this->logmessage("inserted data already exist in the table : $table");
                return false;
            }
        } elseif ($option == 3) {
            
            $select_Sql .= " WHERE ";
            $cols = [];
            $params = [];
            $types_ = "";


            foreach ($conditions as $col => $value) {
                $cols[] = "$col = ?";
                $params[] = $value;
                $types_ .= match (gettype($value)) {
                    'integer' => 'i',
                    'double' => 'd',
                    default => 's',
                };
            }

            $select_Sql .= implode(" AND ", $cols);

            $stmt = $this->conn->prepare($select_Sql);

            if (!empty($params)) {
                $stmt->bind_param($types_, ...$params);
            }

            $stmt->execute();


            $result = $stmt->get_result();

            if ($result && $result->num_rows == 0) {
                $stmt = $this->conn->prepare($insert_sql);

                if (!$stmt) {
                    // die("Prepare Failed : " . $this->conn->error);
                    $this->logmessage("Prepare Failed : " . $this->conn->error);
                    // echo "stmt failed\n";
                }

                $stmt->bind_param($types, ...$values);

                // echo "stmt param binded\n";

                $success = $stmt->execute();

                if ($success) {
                    $this->logmessage("Data inserted in $table ....");
                    return true;
                } else {
                    $this->logmessage("Data cannot be inserted $table ....");
                    return false;
                }
            } else {
                $this->logmessage("inserted data already exist in the table : $table");
                return false;
            
            }
        }
    }

    function getData(array $data = [], string $table, array $specific_value = [], int $option)
    {
        $output = [];
        $spec_column = implode("", array_keys($specific_value));
        $spec_col_value = implode("", $specific_value);
        // echo $spec_column . " => " . $spec_col_value . "\n";

        if (count($data) > 0) {
            $columns = implode(",", $data);
        } else {
            $columns = "*";
        }
        $select_Sql = "SELECT $columns FROM $table";
        $select_Sql_value = "SELECT $columns FROM $table WHERE $spec_column = '$spec_col_value';";


        // echo "this is data count : " . count($data) . "\n";

        // $rows_values = explode(",", $columns);



        // option 1 to fetch all the data for all columns or specific columns
        if ($option == 1) {
            $stmt = $this->conn->prepare($select_Sql);

            if (!$stmt) {
                die("Prepare Failed : " . $this->conn->error);
                $this->logmessage("Prepare Failed : " . $this->conn->error);
            }



            // $stmt->bind_param($types, ...$values);

            $stmt->execute();


            $result = $stmt->get_result();


            if ($result->num_rows > 0) {
                while ($rows = $result->fetch_assoc()) {

                    if (count($data) > 0) {
                        // foreach ($rows_values as $key => $value) {
                        //     echo "$value : " . $rows[$value] . " __\n";

                        // }
                        $output[] = $rows;
                    } else {
                        // foreach ($rows as $key => $value) {
                        //     echo "$key : $value _____\n";

                        // }
                        $output[] = $rows;
                    }
                }
                // loggig the functionallity done 
                $this->logmessage("Query executed: " . (count($data) ? "Specific Columns data fetched ....." : "All the data is fetched ....."));
                return $output;
            }
        }

        // fetching data for specific entity
        elseif ($option == 2) {

            $stmt = $this->conn->prepare($select_Sql_value);

            if (!$stmt) {
                die("Prepare Failed : " . $this->conn->error);
                $this->logmessage("Prepare Failed : " . $this->conn->error);
            }



            // $stmt->bind_param($types, ...$values);

            $stmt->execute();


            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($rows = $result->fetch_assoc()) {

                    if (count($data) > 0) {
                        // foreach ($rows_values as $key => $value) {
                        //     echo "$value : " . $rows[$value] . " __\n";

                        // }
                        $output[] = $rows;
                    } else {
                        // foreach ($rows as $key => $value) {
                        //     echo "$key : $value _____\n";

                        // }
                        $output[] = $rows;
                    }
                }
                // loggig the functionallity done 
                $this->logmessage("Query executed: " . (count($data) ? "specific columns Data fetched for specific entry ....." : "All the data is fetched for specific entry ....."));
                return $output;
            }
            $this->logmessage("Query executed: " . (count($data) ? "No Data fetched for specific entry ....." : "No data is fetched for specific entry ....."));
            return $output;
        } elseif ($option == 3) {
            $select_Sql .= " WHERE ";
            $cols = [];
            $params = [];
            $types = "";


            foreach ($specific_value as $col => $value) {
                $cols[] = "$col = ?";
                $params[] = $value;
                $types .= match (gettype($value)) {
                    'integer' => 'i',
                    'double' => 'd',
                    default => 's',
                };
            }

            $select_Sql .= implode(" AND ", $cols);

            $stmt = $this->conn->prepare($select_Sql);

            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }

            $stmt->execute();


            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($rows = $result->fetch_assoc()) {

                    if (count($data) > 0) {
                        // foreach ($rows_values as $key => $value) {
                        //     echo "$value : " . $rows[$value] . " __\n";

                        // }
                        $output[] = $rows;
                    } else {
                        // foreach ($rows as $key => $value) {
                        //     echo "$key : $value _____\n";

                        // }
                        $output[] = $rows;
                    }
                }
                // loggig the functionallity done 
                $this->logmessage("Query executed: " . (count($data) ? "specific columns Data fetched for specific entry ....." : "All the data is fetched for specific entry ....."));
                return $output;
            }
            $this->logmessage("Query executed: " . (count($data) ? "No Data fetched for specific entry ....." : "No data is fetched for specific entry ....."));
            return $output;
        }
    }

    function remove_Data(array $data, string $table, int $option)
    {

        $columns = implode("", array_keys($data));
        $placeHolders = implode(", ", array_fill(0, count($data), '?'));

        // echo "table name is : $table\n";
        $delete_Sql_all = "DELETE FROM $table;";
        $delete_Sql_Spec = "DELETE FROM $table WHERE $columns = $placeHolders;";


        $types = '';
        $values = [];

        foreach ($data as $value) {
            $types .= match (gettype($value)) {
                'integer' => 'i',
                'double' => 'd',
                default => 's',
            };
            $values[] = $value;
        }

        if ($option == 1) {
            $stmt = $this->conn->prepare($delete_Sql_all);

            if (!$stmt) {
                die("Prepare Failed : " . $this->conn->error);
                $this->logmessage("Prepare Failed : " . $this->conn->error);
            }



            // $stmt->bind_param($types, ...$values);

            $executed = $stmt->execute();


            $this->logmessage("Query executed: " . ($executed ? "All the rows of $table deleted ....." : "Failed to delete the rows : " . $this->conn->error . " !!!"));
            return $executed;
        } else if ($option == 2) {
            $stmt = $this->conn->prepare($delete_Sql_Spec);

            if (!$stmt) {
                die("Prepare Failed : " . $this->conn->error);
                $this->logmessage("Prepare Failed : " . $this->conn->error);
            }



            $stmt->bind_param($types, ...$values);

            $executed = $stmt->execute();
            $this->logmessage("Query executed: " . ($executed ? "All the rows of $table deleted for $columns entry ....." : "Failed to delete the rows : " . $this->conn->error . " !!!"));
            return $executed;
        } else if ($option == 3) {
            $setParts = [];
            $params   = [];
            $types    = "";



            $whereParts = [];
            foreach ($data as $col => $val) {
                $whereParts[] = "`$col` = ?";
                $params[]     = $val;
                $types .= match (gettype($val)) {
                    'integer' => 'i',
                    'double' => 'd',
                    default => 's',
                };
            }

            $sql = "DELETE FROM $table WHERE " . implode(" AND ", $whereParts);

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param($types, ...$params);
            $executed = $stmt->execute();

            return $executed;
        }
    }

    function update_Data($table, $data = [], $conditions = [])
    {
        if (empty($data) || empty($conditions)) {
            return false;
        }
        $setParts = [];
        $params   = [];
        $types    = "";

        foreach ($data as $col => $val) {
            $setParts[] = "`$col` = ?";
            $params[]   = $val;
            $types .= match (gettype($val)) {
                'integer' => 'i',
                'double' => 'd',
                default => 's',
            };
        }

        $whereParts = [];
        foreach ($conditions as $col => $val) {
            $whereParts[] = "`$col` = ?";
            $params[]     = $val;
            $types .= match (gettype($val)) {
                'integer' => 'i',
                'double' => 'd',
                default => 's',
            };
        }

        $sql = "UPDATE `$table` SET " . implode(", ", $setParts) .
            " WHERE " . implode(" AND ", $whereParts);

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$params);


        $success = $stmt->execute();
        $this->logmessage("query executed for $table ...........................................................");

        return $success;
    }
}
