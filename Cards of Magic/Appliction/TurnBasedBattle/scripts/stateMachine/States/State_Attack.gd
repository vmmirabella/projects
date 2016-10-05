extends "res://scripts/stateMachine/States/State.gd"

var origin
var units
var tilemap
var camera
	
func onEnter(g):	
	.onEnter(g)
	global.set_info_text("Choose an Enemy to attack", true)
	origin = global.get_active_unit()
	units = global.get_units()
	global.deselect()
	tilemap = global.get_node("TileMap_Floor")
	camera = global.get_camera()
	
func update(delta):
	var target = global.get_selected()
	
	if(origin != target && target != null):
		apply_attack_damage(target)
		global.gameState.change(enums.STATE_ENDTURN)	
		
func input(event):
	if(event.is_action_pressed("ui_cancel")):
		global.deselect()
		global.gameState.pop()
		return
	
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
	
	
func apply_attack_damage(target):
	var strength = origin[enums._ENTITY].get_attribute(enums.ENTITY_STRENGTH)
	var speed = origin[enums._ENTITY].get_attribute(enums.ENTITY_SPEED)
	var name = origin[enums._ENTITY].get_name()
	var damage = strength + (speed*0.5)
	
	target[enums._ENTITY].apply_damage(damage)
	var s = str(name, " attacks ", target[enums._ENTITY].get_name(), " and hits for ", damage )
	
	global.set_info_text(s, true)
	
	
func onExit():	
	.onExit()
	global.gameState.pop() #pop off the unit selected state
			
