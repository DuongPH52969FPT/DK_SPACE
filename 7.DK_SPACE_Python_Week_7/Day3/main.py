# main.py
from book_management import PhysicalBook, EBook, display_books
from library_management import User, Library

def main():
    # Khởi tạo thư viện
    library = Library()

    # Thêm sách vào thư viện
    books = [
        PhysicalBook("PB001", "Clean Code", "Robert C. Martin", 3, "mới"),
        PhysicalBook("PB002", "The Pragmatic Programmer", "Andrew Hunt", 2, "cũ"),
        PhysicalBook("PB003", "Refactoring", "Martin Fowler", 1, "mới"),
        EBook("EB001", "Deep Learning", "Ian Goodfellow", 10, "PDF"),
        EBook("EB002", "Python Tricks", "Dan Bader", 5, "EPUB"),
    ]
    for book in books:
        library.add_book(book)

    # Tạo người dùng
    user1 = User("U001", "Alice")
    user2 = User("U002", "Bob")

    # Người dùng mượn sách
    try:
        user1.borrow_book(library.find_book_by_id("PB001"))
        user1.borrow_book(library.find_book_by_id("EB001"))

        user2.borrow_book(library.find_book_by_id("PB002"))
        user2.borrow_book(library.find_book_by_id("EB002"))
    except ValueError as e:
        print("Borrow Error:", e)

    # Trả lại sách
    try:
        user1.return_book(library.find_book_by_id("PB001"))
    except ValueError as e:
        print("Return Error:", e)

    # Duyệt danh sách sách (Iterator)
    print("\n--- Tất cả sách trong thư viện (Iterator) ---")
    for book in library:
        print(book.get_info())

    # Hiển thị thông tin sách (Polymorphism)
    print("\n--- Hiển thị thông tin sách (Polymorphism) ---")
    display_books(library.books)

    # In danh sách sách đang mượn
    print("\n--- Sách đang được mượn ---")
    print(f"Alice đang mượn: {user1.get_borrowed_books()}")
    print(f"Bob đang mượn: {user2.get_borrowed_books()}")

if __name__ == "__main__":
    main()
