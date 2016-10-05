
extends TileMap

var previousPos = null
var previousTile = null
onready var global = get_node("/root/Field")
var enums = preload("res://scripts/DataObjects/Battle_enums.gd")
var objects
var camera


func _ready():
	set_process(true)
	
	camera = global.get_camera()
	
	
func _process(delta):
	var pos = world_to_map(camera.get_global_mouse_pos())
	var currentTile = get_cellv(pos)
	
	if(previousPos == null):
		previousPos = pos
		previousTile = currentTile
		set_cellv(pos, 2)
	
	#pass over an empty tile
	if(currentTile == -1):
		set_cellv(previousPos,previousTile)
		previousPos = null
		
	elif(pos != previousPos):
		#:todo: Hack to get rid of select tile (0). Should probably find a better way. This wouldn't happen with shaders. 
		if(previousTile == 0):
			previousTile = 1	
		set_cellv(previousPos,previousTile)
		previousPos = pos
		previousTile = currentTile
		set_cellv(pos, 2)

			
			
			


