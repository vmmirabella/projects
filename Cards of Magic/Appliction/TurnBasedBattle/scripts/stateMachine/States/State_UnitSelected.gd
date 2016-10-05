extends "res://scripts/stateMachine/States/State.gd"

var active_unit
var menu = null
var sheet
var floor_tiles
var camera
	
func onEnter(g):	
	.onEnter(g)
	
	active_unit = g.get_selected()
	
	global.create_action_menu()
	menu = global.get_action_menu()
	
	var container
	
	var type = active_unit[enums._ENTITY].get_attribute(enums.ENTITY_TYPE)
	
	if(type == enums.ENTITY_TYPE_FRIENDLY):
		container = global.get_node("GUI/Party")
	elif(type == enums.ENTITY_TYPE_ENEMY):
		container = global.get_node("GUI/Enemy")
	
	var CharacterSheet = preload("res://scenes/CharacterSheet.tscn")
	sheet = CharacterSheet.instance()
	sheet.set_unit(active_unit)
	
	container.add_child(sheet)
	
	global.set_active_unit(active_unit)
	
	floor_tiles = global.get_node("TileMap_Floor")
	camera = global.get_camera()
	generate_move_tiles()
		
	
func update(delta):
	pass
		
func input(event):
	if(event.is_action_pressed("ui_cancel")):
		global.deselect()
		global.gameState.pop()
		return
	var move = active_unit[enums._ENTITY].get_attribute(enums.ENTITY_MOVE)	
	
	#if entity has already moved do nothing.
	if(move[enums.ENTITY_HAS_MOVED]):
		return
	
	if(event.type == InputEvent.MOUSE_BUTTON):
		if(event.button_index == BUTTON_LEFT and event.pressed):
			
			var mouse_pos = floor_tiles.world_to_map(camera.get_global_mouse_pos())
			var unit_pos = active_unit[enums._TILE][enums._TILE_LOCATION]
			var moveDistance = move[enums.ENTITY_MOVE_RANGE]
			
			print(str(moveDistance, "| ", mouse_pos.distance_to(unit_pos)))
			
			if(mouse_pos.distance_to(unit_pos) <= moveDistance):
				generate_move_tiles(true)
				move_sprite(mouse_pos)
				

func move_sprite(pos):
	var _tile = active_unit[enums._TILE]
	
	var new_pos = floor_tiles.map_to_world(pos)
	
	_tile[enums._TILE_LOCATION] = pos
	_tile[enums._TILE_SPRITE].set_pos(new_pos)
	
	active_unit[enums._ENTITY].get_attribute(enums.ENTITY_MOVE)[enums.ENTITY_HAS_MOVED] = true
	


func generate_move_tiles(remove_tiles = false):
	var moveDistance = active_unit[enums._ENTITY].get_attribute(enums.ENTITY_MOVE)[enums.ENTITY_MOVE_RANGE]
	var loc = active_unit[enums._TILE][enums._TILE_LOCATION]
	var object_tiles = global.get_node("TileMap_Floor/TileMap_Objects")
	
	var x_min = loc.x - moveDistance
	var x_max = loc.x + moveDistance + 1
	var y_min = loc.y - moveDistance
	var y_max = loc.y + moveDistance + 1
	
	var type = 0
	
	if(remove_tiles):
		type = 1
	
	
	for x in range(x_min,x_max):
		for y in range(y_min,y_max):
			var distance = loc.distance_to(Vector2(x,y))
			
			if(distance > moveDistance):
				continue
			
			var floor_cell = floor_tiles.get_cell(x,y)
			#:todo: account for other units. Occupied spaces cannot be moved to
			if(floor_cell >= 0):
				floor_tiles.set_cell(x, y, type)
	 
	
	
			
func onExit():
	.onExit()
	global.deselect()
	global.destroy_action_menu()
	sheet.close()