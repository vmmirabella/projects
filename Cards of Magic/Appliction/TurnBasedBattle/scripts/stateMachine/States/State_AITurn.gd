extends "res://scripts/stateMachine/States/State.gd"

	
func onEnter(g):	
	.onEnter(g)
	global.set_info_text("Enemy Turn", true)
	
	var units = global.get_units()
	
	#we must set a random enemy as active so that the end turn state works correctly
	for u in units:
		var u_type = u[enums._ENTITY].get_attribute(enums.ENTITY_TYPE)
		
		if(u_type == enums.ENTITY_TYPE_ENEMY):
			global.set_active_unit(u)
			break
	
	global.gameState.change(enums.STATE_ENDTURN)
	
	

func onExit():
	.onExit()
	global.set_info_text("Enemy Turn not implemented yet. SKIPPING", true)	