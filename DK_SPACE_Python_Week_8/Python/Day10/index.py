import pymongo
from datetime import datetime
myclient = pymongo.MongoClient("mongodb://localhost:27017/")


def setup_database () :
    mydb = myclient["online_store"]

    
    products_col = mydb["products"]
    orders_col = mydb["orders"]
    if "products" not in mydb.list_collection_names():
        mydb.create_collection("products")
    if "orders" not in mydb.list_collection_names():
        mydb.create_collection("orders")
    return products_col, orders_col


def add_data ():

    products_col,orders_col = setup_database()
    
    products_dict = [
        {"product_id" : "SP001", "name": "Áo thun", "price": 150000.0, "stock": 50},
        {"product_id": "SP002", "name": "Quần jean", "price": 350000.0, "stock": 30},
        {"product_id": "SP003", "name": "Áo sơ mi", "price": 250000.0, "stock": 40},
        {"product_id": "SP004", "name": "Giày thể thao", "price": 600000.0, "stock": 20},
        {"product_id": "SP005", "name": "Mũ lưỡi trai", "price": 80000.0, "stock": 100}
    ]

    orders_dict = [
        {
            "order_id": "DH002",
            "customer_name": "Bình",
            "product_id": "SP002",
            "quantity": 2,
            "total_price": 700000.0,
            "order_date": datetime(2025, 4, 12)
        },
        {
            "order_id": "DH003",
            "customer_name": "Châu",
            "product_id": "SP003",
            "quantity": 1,
            "total_price": 250000.0,
            "order_date": datetime(2025, 4, 13)
        },
        {
            "order_id": "DH004",
            "customer_name": "Dũng",
            "product_id": "SP004",
            "quantity": 1,
            "total_price": 600000.0,
            "order_date": datetime(2025, 4, 14)
        },
        {
            "order_id": "DH005",
            "customer_name": "Hà",
            "product_id": "SP005",
            "quantity": 3,
            "total_price": 240000.0,
            "order_date": datetime(2025, 4, 15)
        },
        {
            "order_id": "DH006",
            "customer_name": "Khánh",
            "product_id": "SP001",
            "quantity": 2,
            "total_price": 300000.0,
            "order_date": datetime(2025, 4, 16)
        },
        {
            "order_id": "DH007",
            "customer_name": "Linh",
            "product_id": "SP003",
            "quantity": 2,
            "total_price": 500000.0,
            "order_date": datetime(2025, 4, 17)
        },
        {
            "order_id": "DH008",
            "customer_name": "Minh",
            "product_id": "SP002",
            "quantity": 1,
            "total_price": 350000.0,
            "order_date": datetime(2025, 4, 18)
        },
        {
            "order_id": "DH009",
            "customer_name": "Ngọc",
            "product_id": "SP004",
            "quantity": 1,
            "total_price": 600000.0,
            "order_date": datetime(2025, 4, 19)
        },
        {
            "order_id": "DH010",
            "customer_name": "Phúc",
            "product_id": "SP005",
            "quantity": 4,
            "total_price": 320000.0,
            "order_date": datetime(2025, 4, 20)
        }
    ]
    products_col.insert_many(products_dict)
    orders_col.insert_many(orders_dict)

import pymongo
from datetime import datetime
myclient = pymongo.MongoClient("mongodb://localhost:27017/")


def setup_database () :
    mydb = myclient["online_store"]

    
    products_col = mydb["products"]
    orders_col = mydb["orders"]
    if "products" not in mydb.list_collection_names():
        mydb.create_collection("products")
    if "orders" not in mydb.list_collection_names():
        mydb.create_collection("orders")
    return products_col, orders_col


def add_data ():

    products_col,orders_col = setup_database()
    
    
    if products_col.count_documents({}) == 0:
        products_col.insert_many([
            {"product_id" : "SP001", "name": "Áo thun", "price": 150000.0, "stock": 50},
            {"product_id": "SP002", "name": "Quần jean", "price": 350000.0, "stock": 30},
            {"product_id": "SP003", "name": "Áo sơ mi", "price": 250000.0, "stock": 40},
            {"product_id": "SP004", "name": "Giày thể thao", "price": 600000.0, "stock": 20},
            {"product_id": "SP005", "name": "Mũ lưỡi trai", "price": 80000.0, "stock": 100}
        ])

    if orders_col.count_documents({}) == 0:
        orders_col.insert_many([
        {
            "order_id": "DH001",
            "customer_name": "An",
            "product_id": "SP001",
            "quantity": 1,
            "total_price": 150000.0,
            "order_date": datetime(2025, 4, 12)
        },
        {
            "order_id": "DH002",
            "customer_name": "Bình",
            "product_id": "SP002",
            "quantity": 2,
            "total_price": 10000.0,
            "order_date": datetime(2025, 4, 12)
        },
        {
            "order_id": "DH003",
            "customer_name": "Châu",
            "product_id": "SP003",
            "quantity": 1,
            "total_price": 250000.0,
            "order_date": datetime(2025, 4, 13)
        },
        {
            "order_id": "DH004",
            "customer_name": "Dũng",
            "product_id": "SP004",
            "quantity": 1,
            "total_price": 600000.0,
            "order_date": datetime(2025, 4, 14)
        },
        {
            "order_id": "DH005",
            "customer_name": "Hà",
            "product_id": "SP005",
            "quantity": 3,
            "total_price": 240000.0,
            "order_date": datetime(2025, 4, 15)
        },
        {
            "order_id": "DH006",
            "customer_name": "Khánh",
            "product_id": "SP001",
            "quantity": 2,
            "total_price": 300000.0,
            "order_date": datetime(2025, 4, 16)
        },
        {
            "order_id": "DH007",
            "customer_name": "Linh",
            "product_id": "SP003",
            "quantity": 2,
            "total_price": 500000.0,
            "order_date": datetime(2025, 4, 17)
        },
        {
            "order_id": "DH008",
            "customer_name": "Minh",
            "product_id": "SP002",
            "quantity": 1,
            "total_price": 350000.0,
            "order_date": datetime(2025, 4, 18)
        },
        {
            "order_id": "DH009",
            "customer_name": "Ngọc",
            "product_id": "SP004",
            "quantity": 1,
            "total_price": 600000.0,
            "order_date": datetime(2025, 4, 19)
        },
        {
            "order_id": "DH010",
            "customer_name": "Phúc",
            "product_id": "SP005",
            "quantity": 4,
            "total_price": 320000.0,
            "order_date": datetime(2025, 4, 20)
        }
    ])

def query_orders(customer):
    products_col,orders_col = setup_database()

    # 1. Đơn hàng của khách hàng cụ thể
    print(f"\nĐơn hàng của {customer}:")
    customer_orders = orders_col.find({"customer_name": {"$eq": customer}})
    for order in customer_orders:
        print(f"- Mã đơn: {order['order_id']}, Sản phẩm: {order['product_id']}, Tổng: {order['total_price']} VNĐ")

    # 2. Tìm đơn hàng có total_price > 500000
    print("\nĐơn hàng có tổng giá trị trên 500000:")
    max_orders = orders_col.find({"total_price": {"$gt": 500000}})
    for order in max_orders:
        print(f"- Mã đơn: {order['order_id']}, Sản phẩm: {order['product_id']}, Tổng: {order['total_price']} VNĐ")

    # 3. Sắp xếp giảm dần theo tổng giá
    print("\nTất cả đơn hàng (giảm dần theo tổng giá trị):")
    sorted_orders = orders_col.find().sort([("total_price", -1)])
    for order in sorted_orders:
        print(f"- Mã đơn: {order['order_id']}, Sản phẩm: {order['product_id']}, Tổng: {order['total_price']} VNĐ")

    # 4. Giới hạn 5 đơn hàng đầu tiên
    print("\n5 đơn hàng đầu tiên:")
    limited_orders = orders_col.find().limit(5)
    for order in limited_orders:
        print(f"- Mã đơn: {order['order_id']}, Sản phẩm: {order['product_id']}, Tổng: {order['total_price']} VNĐ")



def update_order(order_id, quantity):
    products_col, orders_col = setup_database()
    
    # Tìm đơn hàng
    order = orders_col.find_one({"order_id": order_id})
    if not order:
        print("Không tìm thấy đơn hàng.")
        return

    # Tìm sản phẩm để lấy giá
    product = products_col.find_one({"product_id": order["product_id"]})
    if not product:
        print("Không tìm thấy sản phẩm.")
        return

    # Tính lại total_price
    total_price = quantity * product["price"]

    # Cập nhật đơn hàng
    orders_col.update_one(
        {"order_id": order_id},
        {"$set": {"quantity": quantity, "total_price": total_price}}
    )

    print(f"Đã cập nhật đơn hàng {order_id}: quantity = {quantity}, total_price = {total_price} VNĐ")

def delete_order():
    _, orders_col = setup_database()

    # Xóa các đơn hàng có total_price < 100000
    result = orders_col.delete_many({"total_price": {"$lt": 100000}})
    print(f"\nĐã xóa {result.deleted_count} đơn hàng có tổng giá trị < 100000.")

def generate_report():
    products_col, orders_col = setup_database()

    print("\nBáo cáo cửa hàng:")

    # 1. Tính doanh thu theo product_id
    pipeline = [
        {"$group": {
            "_id": "$product_id",
            "doanh_thu": {"$sum": "$total_price"}
        }}
    ]
    revenue_by_product = orders_col.aggregate(pipeline)
    for item in revenue_by_product:
        print(f"- Sản phẩm {item['_id']}: Doanh thu {item['doanh_thu']} VNĐ")

    # 2. Tìm sản phẩm tồn kho < 10
    low_stock = products_col.find({"stock": {"$lt": 10}})
    low_stock_count = products_col.count_documents({"stock": {"$lt": 10}})
    print(f"- Sản phẩm tồn kho thấp: {low_stock_count} sản phẩm")

def cleanup_database():
    mydb = myclient["online_store"]
    if "orders" in mydb.list_collection_names():
        mydb.drop_collection("orders")
        print("\nCollection 'orders' đã được xóa.")
    else:
        print("\ Collection 'orders' không tồn tại.")

def main():
    setup_database()
    add_data()
    query_orders("An")
    update_order("DH003", 3)
    delete_order()
    generate_report()
    # cleanup_database()
    
main()