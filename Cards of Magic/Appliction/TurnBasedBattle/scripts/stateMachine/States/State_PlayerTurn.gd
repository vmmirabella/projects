extends "res://scripts/stateMachine/States/State.gd"

var tilemap
var camera
	
func onEnter(g):	
	.onEnter(g)
	global.set_info_text("Your Turn", true)
	tilemap = global.get_node("TileMap_Floor")
	camera = global.get_camera()

		
func input(event):
	
	
	if(event.type == InputEvent.MOUSE_BUTTON):
		if(event.button_index == BUTTON_LEFT and event.pressed):
			
			var pos = tilemap.world_to_map(camera.get_global_mouse_pos())
			print(str(camera.get_global_mouse_pos(), " ", pos))
			var units = global.get_units()
			if(tilemap.get_cellv(pos) >= 0):
				for u in units:
					if(u[enums._TILE][enums._TILE_LOCATION] == pos):
						if(u[enums._ENTITY].get_attribute(enums.ENTITY_ENDTURN) == false):
							global.set_selected(u)
							global.gameState.push(enums.STATE_UNITSELECTED)
							break
						else:
							global.set_info_text("This unit has already finished its turn. Please select another", true)
		
func onExit():
	.onExit()
	
	
