



CREATE TABLE tbl_admin (
    
    id          INTEGER unsigned PRIMARY KEY auto_increment,
    fullname    VARCHAR(100) NOT NULL,
    username    VARCHAR(100) NOT NULL,
    password    VARCHAR(255) NOT NULL,
);

-- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- 

CREATE TABLE tbl_category (
    
    id          INTEGER unsigned PRIMARY KEY auto_increment,
    title       VARCHAR(100) NOT NULL,
    image_name  VARCHAR(255) NOT NULL,
    featured    VARCHAR(10)  NOT NULL,
    active      VARCHAR(10)  NOT NULL
);

-- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- 

CREATE TABLE tbl_food (
    
    id           INTEGER unsigned PRIMARY KEY auto_increment,
    title        VARCHAR(150)     NOT NULL,
    description  VARCHAR(255)     NOT NULL,
    price        DECIMAL(10.2)    NOT NULL,
    image_name   VARCHAR(255)     NOT NULL,
    category_id  INTEGER unsigned NOT NULL,        ----- Foreign key
    featured     VARCHAR(10)      NOT NULL,
    active       VARCHAR(10)      NOT NULL
);

-- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- 

CREATE TABLE tbl_order (
    
    id                INTEGER unsigned   PRIMARY KEY auto_increment,
    food              VARCHAR(150)       NOT NULL,
    price             VARCHAR(255)       NOT NULL,
    qty               DECIMAL(10.2)      NOT NULL,
    total             VARCHAR(255)       NOT NULL,
    order_date        INTEGER unsigned   NOT NULL,
    status            VARCHAR(10)        NOT NULL,      
    customer_name     VARCHAR(150)       NOT NULL,
    customer_contact  VARCHAR(20)        NOT NULL,
    customer_email    VARCHAR(150)       NOT NULL,
    customer_address  VARCHAR(255)       NOT NULL
);

-- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- 


-- @-- functions 

    
-- define("LOCALHOST", "localhost");
-- define("DB_USERNAME", "root");
-- define("DB_PASSWORD", "");

-- ++          mysqli_connect()
-->    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) ;

-- ------------------------

-- define("DB_NAME", "food-order");

--   $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));

-- ------------------------

$sql = "SELECT * FROM tbl_admin";

-- ++          mysqli_query()
--->    $res = mysqli_query($conn, $sql);

-- ++            mysqli_num_rows()
--->    $count = mysqli_num_rows($res); 

-- ------------------------


-- ++           mysqli_fetch_assoc()
        $rows = mysqli_fetch_assoc($res)

-- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- 

-- To escape dangerous chars

-- ++        mysqli_real_escape_string()
$full_name = mysqli_real_escape_string($conn, $_POST["full_name"]);

-- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- 



