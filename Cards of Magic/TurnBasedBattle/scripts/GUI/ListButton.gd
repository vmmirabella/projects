
extends Button

var window #:member window (Node): Window that the button belongs to
var description #:member description (string): Text to send back to the window when the button is hovered over

func _ready():
	window = get_node("../../../../..")

func _pressed():
	""" Sends a signal to the associated window
	"""
	window.set_pressed(get_text())
	
func set_data(name, description):
	"""" Sets the text in the button and description to be stored
	
	:param name (string): Text set on the button
	
	:param description (string): descriiption to store
	"""
	self.description = str(name, " - ", description)
	set_text(name)

func _on_Button_mouse_enter():
	""" Set the text in the info window when the button is hovered over
	"""
	window.Text.set_bbcode(description)
