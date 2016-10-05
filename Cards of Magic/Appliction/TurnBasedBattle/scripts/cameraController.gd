
extends Camera2D

onready var viewport = get_viewport()
onready var screen = get_viewport_rect()

func _ready():
	set_process(true)
	
	
func _process(delta):
	var mouse_pos = viewport.get_mouse_pos()
	var scale = 0.97 
	
	# If the mouse moves outside of these bounds the camera will move
	# Bounds are created by scaling the viewport rect inwards by a specified amount
	var top = mouse_pos.y < screen.size.height*(1 - scale)
	var bottom = mouse_pos.y > screen.size.height*scale
	var left = mouse_pos.x < screen.size.width*(1 - scale)
	var right = mouse_pos.x > screen.size.width*scale
	
	if(top or bottom or left or right):
		var camera_pos = get_global_pos()
		var centre = screen.size * 0.5 #centre of screen
		
		#http://stackoverflow.com/questions/5483937/direction-of-two-points
		#Gets direction of mouse relative to the centre of the screen
		var direction = (mouse_pos - centre).normalized()
		
		camera_pos += direction * delta * 400
		set_global_pos(camera_pos)
	
	
	
	
	
	

