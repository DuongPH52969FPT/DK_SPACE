


# Variables = Biến
# # gtr_price = 600.99;
# # gtr_age = 10
# # in_stock = False
# # is_guitar_new = False

# # # print(f"This guitar is a {Guitar} and it costs ${gtr_price}. It is age is {gtr_age}, its in stock {in_stock} and new {is_guitar_new}.")

# # if in_stock:
# #     print("It's in stock!")
# # else:
# #     print("It's not in stock!")

# Guitar = bool(20.20)
# GuitarType = type(Guitar)

# print(f"The type of Guitar is {Guitar}")

# input

# name = input("Enter your name: ")
# age = int(input("Enter your age: "))
# age += 1  # Increment age by 1
# print(f"Hello {name}!")
# print(f"You are {age} years old!")

# itemname1 = input("Enter the item name: ")
# itemprice1 = float(input("Enter the item price: "))
# quantity1 = int(input("Enter item quantity: "))
# total = quantity1 * itemprice1
# print(f"Your item is {itemname1}, price is {itemprice1}, quantity is {quantity1}, and total is {total}")


# math - toán

# friends = 10

# # friends += 1
# # friends -= 2
# # friends = friends * 3
# # friends *= 3

# # friends = friends / 2
# # friends /= 2
# # friends = friends ** 2
# # friends **=2 

# remainder = friends % 3



# result = round(x)

# result = abs(-4)

# result = pow(4,3)

# x = 3.14

# y = 4

# z = 5

# # result = max(x,y,z)
# result = min(x,y,z)


# print(result)

# import math 


# print(math.pi)
# print(math.e)

# x = 9.1
# # result = math.sqrt(x)
# # result = math.floor(x) 
# print(result)

# radius = float(input("Enter the radius of a circle: "))

# circumference = 2 * math.pi * radius

# print(f"circumference is {round(circumference, 2)}cm")

# radius = float(input("Enter the radius of a circle: "))

# area = math.pi * pow(radius,2)

# print(f"area of a circle is {round(area,2)}cm")

# a = float(input("Enter a: "))
# b = float(input("Enter b: "))

# c = math.sqrt(pow(a,2) + pow(b,2))

# print(f" c = {c}")


# if else calculator

#calculator

# calcformat = input("Enter format (+  -  *  /): ")
# number1 = int(input("Enter number 1: "))
# number2 = int(input("Enter number 2: "))


# if calcformat == "+" : 
#     print(number1 + number2)
# elif calcformat == "-" :
#     print(number1 - number2)
# elif calcformat == "*" :
#     print(number1 * number2)
# elif calcformat == "/" :
#     print(number1 / number2)
# else : 
#     print ("Error")


# Pound to kg
# import math

# value = input("Enter what type of value do you want kilogram or pounds (K/P)")
# number = float(input("Enter your weight: "))


# if value == "K" :
#     kgtop = number * 2.20462
#     print(f"Your are {kgtop} pounds!")
# elif value == "P" :
#     kgtop = number / 2.20462
#     print(f"Your are {kgtop} kg!")
# else : 
#     print(f"{value}Is not valid")

# celcius to farenheit


# temp = float(input("Enter value: "))

# unit = input("Enter unit F / C: ").strip().upper()


# if unit == "F":
#     Fahrenheit = temp * 9 / 5 + 32
#     unit = "Fahrenheit"
#     print(f"Converted {Fahrenheit} {unit}°")
# elif unit == "C" : 
#     Celsius = (temp - 32) * 5 / 9
#     unit = "Celsius"
#     print(f"Converted {Celsius} {unit} ")
# else : 
#     print("Error")


# temperature = 20

# weather = "Hot" if temperature >=30 else "Cold"

# print(weather)

    
# a = 10

# b = 20

# max_num = a if a > b else b
# min_num = a if a < b else b

# print(min_num)


name = input("Enter your name: ")
phone_number = input("Enter your phone_number: ")


# result = name.find("D") first
# result = name.rfind("D") last
result = name.capitalize()
result = name.upper()
result = name.lower()
result = name.strip()

result = phone_number.count("-")
result = phone_number.replace("-", " ")

# result = name.isdigit() true / false digit

# result = name.isalpha() true false alphabet no space


print(result)