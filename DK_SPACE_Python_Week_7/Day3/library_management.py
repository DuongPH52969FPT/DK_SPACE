# library_management.py
from book_management import Book, PhysicalBook, EBook

class User:
    def __init__(self, user_id, name):
        self.__user_id = user_id  # private
        self.name = name
        self.borrowed_books = []  # list of book IDs

    def get_user_id(self):
        return self.__user_id

    def borrow_book(self, book: Book):
        if book.stock > 0:
            book.update_stock(-1)
            self.borrowed_books.append(book.get_book_id())
        else:
            raise ValueError("Book is out of stock")

    def return_book(self, book: Book):
        if book.get_book_id() in self.borrowed_books:
            book.update_stock(1)
            self.borrowed_books.remove(book.get_book_id())
        else:
            raise ValueError("Book not borrowed by this user")

    def get_borrowed_books(self):
        return self.borrowed_books

class Library:
    def __init__(self):
        self.books = []  # list of Book

    def add_book(self, book):
        self.books.append(book)

    def __iter__(self):
        self._index = 0
        self.books.sort(key=lambda b: b.title)
        return self

    def __next__(self):
        if self._index < len(self.books):
            result = self.books[self._index]
            self._index += 1
            return result
        else:
            raise StopIteration

    def find_book_by_id(self, book_id):
        for book in self.books:
            if book.get_book_id() == book_id:
                return book
        raise ValueError("Book ID not found")
