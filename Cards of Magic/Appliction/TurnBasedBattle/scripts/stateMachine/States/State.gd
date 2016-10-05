extends Object

var enums = preload("res://scripts/DataObjects/Battle_enums.gd")
var global #:member global (node): Reference to the global object

func _ready():
	global = get_node("/root/global")

func update(delta):
	""" Called every frame if it's the current state (state at the top of the stack)
	
	:param delta (float): Time since last frame 
	"""
	pass

func onEnter(global):
	""" Called when a state is pushed on to the stack in StateMachine
	
	
	:param global (node): Reference to the global object
	"""
	self.global = global
	
func input(event):
	pass
	
func onExit():
	""" Called when the state is popped off the top of the stack in StateMachine
	"""
	pass
	