
extends Node

var Title #:member Title (node): Reference to the window's Title node
var Items #:member Items (node): Reference to the container that will hold all of the buttons
var Text #:member Text (node): Reference to the textbox that displays the description
var button #:member button (node): Reference to the button used as a template from which all other buttons are generated
onready var ScrollableList = get_node(".") #:member ScrollableList (node): Reference to self
var global #:member global (node): Reference to the global object
var pressed = null #:member pressed (string): Text of the last button that was pressed

func _ready():
	Title = get_node("ListWindow/BackPanel/Title")
	Items = get_node("ListWindow/BackPanel/ScrollContainer/VBoxContainer")
	Text = get_node("ListWindow/BackPanel/RichTextLabel")
	button = Items.get_node("Button")
	
func init(g):
	""" Passes in the global object
	
	:param g (node): Reference to the global object
	"""
	self.global = g
	
func remove_placeholder_button():
	""" Removes the template button. Should be called after all buttons have been added
	"""
	button.remove_and_skip()
	
func add_button(name, description):
	""" Adds a button to the window
	
	:param name (string):	Name of the button. Will appear as button text
		
	:param description (string): Description that appears in the Text node when button is hovered over.
	"""	
	var temp = button.duplicate(false)
		
	Items.add_child(temp, true)
	temp.set_data(name, description)

func set_title(bbcode):
	""" Sets the window title bar text
	
	:param bbcode (string): Text to set
	"""
	Title.set_bbcode(bbcode)
	
func set_pressed(name):
	""" Called when a button is pressed
	
	Function recieves the name of the last putton that the user pressed in the window
	
	:param name (string): Text of the button that was pressed
	"""
	pressed = name
	
func get_pressed():
	""" Returns the text of the last button that was pressed
	
	:returns pressed (string): Text of the last button that was pressed
	"""
	return pressed
	
func close():
	""" Destroys the window
	""" 
	queue_free()


