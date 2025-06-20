# book_management.py

class Book:
    def __init__(self, book_id, title, author, stock):
        self.__book_id = book_id  # private
        self.title = title
        self.author = author
        self.stock = stock

    def get_book_id(self):
        return self.__book_id

    def get_info(self):
        return f"[Book] {self.title} by {self.author} | Stock: {self.stock}"

    def update_stock(self, amount):
        if self.stock + amount >= 0:
            self.stock += amount
        else:
            raise ValueError("Stock cannot be negative")

class PhysicalBook(Book):
    def __init__(self, book_id, title, author, stock, condition):
        super().__init__(book_id, title, author, stock)
        self.condition = condition

    def get_info(self):
        return f"[PhysicalBook] {self.title} by {self.author} | Condition: {self.condition} | Stock: {self.stock}"

class EBook(Book):
    def __init__(self, book_id, title, author, stock, file_format):
        super().__init__(book_id, title, author, stock)
        self.file_format = file_format

    def get_info(self):
        return f"[EBook] {self.title} by {self.author} | Format: {self.file_format} | Stock: {self.stock}"


def display_books(book_list):
    for book in book_list:
        print(book.get_info())
