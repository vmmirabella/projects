extends Object

var State = preload("res://scripts/stateMachine/States/State.gd")

var list = {} #:member list (Dictionary): Dictionary of loaded scripts
var stack = [] #member stack (Array): Stack of State objects in use by the State Machine

var g #:member g (node): Reference to the global object 

func init(g):
	self.g = g

func push(state):
	""" Pushes a state on to the stack and calls onEnter()
	
	:param state (enum): State to be pushed on to the stack
	""" 
	
	if(state in list):
		stack.push_front(list[state].new())
		stack[0].onEnter(g)
	
func pop():
	""" Pops the state off of the stack and calls onExit()
	"""
	if(not stack.empty()):
		var exiting = stack[0]
		stack.pop_front()
		exiting.onExit()

func get_current_state():
	""" Returns the current state
	
	:returns value (State): Returns the current state at the top of the stack or null if stack is empty
	"""
	
	if(stack.empty()):
		return null
		
	return stack[0];
	
func update(delta):
	""" Calls update() on the current state
	
	:param delta (float): Time since last frame
	"""
	if(not stack.empty()):
		stack[0].update(delta)
		
func input(event):
	if(not stack.empty()):
		stack[0].input(event)
			
func add(stateName):
	""" Loads a State script and places it in the list dictionary
	
	:param stateName (enum): State to be loaded. 
	This is from the STATE dictionary that maps strings to their enums
	"""
	
	var path = "res://scripts/stateMachine/States/State_"			
	list[stateName] = load(str(path,g.enums.STATE[stateName],".gd"))
	
func change(statename):
	""" pops() the current state off of the stack and push() statename on to the stack
	
	:param state (enum): state to be pushed on to the stack
	"""
	pop()
	push(statename)
