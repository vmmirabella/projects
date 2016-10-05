extends "res://scripts/stateMachine/States/State.gd"

var ScrollableList = preload("res://scenes/ScrollableList.tscn")
var window = null
var phase = -1
var effect = null
var tilemap
var camera

		
func update(delta):
	if(window):
		var pressed = window.get_pressed()
		if(pressed != null && phase < 0):
			phase = 0
			global.effects.add("MagicDamage")
			effect = global.effects.get_effect("MagicDamage").new()
			effect.init(global, global.get_active_unit(), pressed)
			window.close()
			window = null
	if(phase == 0 && effect.onSelectTarget()):
		phase = 1
		effect.onCast()
		global.gameState.change(enums.STATE_ENDTURN)
		
func input(event):
	if(event.type == InputEvent.MOUSE_BUTTON):
		if(event.button_index == BUTTON_LEFT and event.pressed):
			
			var pos = tilemap.world_to_map(camera.get_global_mouse_pos())
			print(str(camera.get_global_mouse_pos(), " ", pos))
			var units = global.get_units()
			if(tilemap.get_cellv(pos) >= 0):
				for u in units:
					if(u[enums._TILE][enums._TILE_LOCATION] == pos):
						global.set_selected(u)
						break
		
func create_window():
	""" Creates a ScrollableList window
	
	After creating the window it pushes the MagicDamage state on to the stack
	"""
	var actionMenu = global.get_action_menu()
	
	window = ScrollableList.instance()
	actionMenu.get_node("..").add_child(window)
	window.init(global)
	window.set_title("Magic Window")
	
	var unit = global.get_active_unit()
	var job = unit[enums._ENTITY].get_attribute(enums.ENTITY_JOB)
	var level = unit[enums._ENTITY].get_attribute(enums.ENTITY_LEVEL)
	var magic = job.get_magic()
	var keys = magic.keys() 
	
	#creates buttons for the scrollable list window
	for k in keys:
		global.effects.add("MagicDamage")
		var e = global.effects.get_effect("MagicDamage")
		var temp = e.new()
		temp.init(global, global.get_active_unit(), k)
		if (temp.get_level_requirement() <= level):
			window.add_button(temp.get_name(), temp.get_description())
	
	#should always be called after all buttons have been added
	window.remove_placeholder_button()

func onEnter(g):
	.onEnter(g)
	tilemap = global.get_node_ref("TileMap_Floor")
	camera = global.get_camera()
	create_window()
	
	

	
func onExit():
	.onExit()
	
	global.gameState.pop() #pop off the unit selected state