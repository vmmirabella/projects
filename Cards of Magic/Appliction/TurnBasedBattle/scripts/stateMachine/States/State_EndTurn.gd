extends "res://scripts/stateMachine/States/State.gd"
	
func onEnter(g):
	""" Clears all selections and pops the current state off the stack
	"""	
	.onEnter(g)
	
	global.set_info_text("End Turn", true)
	

	#make the next unit in the action queue active (it is now that unit's turn)
	var active_unit = global.get_active_unit()
	
	active_unit[enums._ENTITY].set_attribute(enums.ENTITY_ENDTURN, true)
	
	var type = active_unit[enums._ENTITY].get_attribute(enums.ENTITY_TYPE)
	
	#if all units have finished thier turn change sides
	var all_end_turn = true
	
	var units = global.get_units()
	
	for u in units:
		var u_type = u[enums._ENTITY].get_attribute(enums.ENTITY_TYPE)
		
		if(u_type == type):
			var end_turn = u[enums._ENTITY].get_attribute(enums.ENTITY_ENDTURN) 
			if(end_turn == false):
				all_end_turn = false
				break
	
	
	if(all_end_turn):
		#reset all end turn and move flags to false
		for u in units:
			u[enums._ENTITY].set_attribute(enums.ENTITY_ENDTURN, false)
			u[enums._ENTITY].get_attribute(enums.ENTITY_MOVE)[enums.ENTITY_HAS_MOVED] = false 
		
		if(type == enums.ENTITY_TYPE_FRIENDLY):
			global.gameState.change(enums.STATE_AITURN)
		elif(type == enums.ENTITY_TYPE_ENEMY):
			global.gameState.change(enums.STATE_PLAYERTURN)
	else:
		if(type == enums.ENTITY_TYPE_FRIENDLY):
			global.gameState.change(enums.STATE_PLAYERTURN)
		elif(type == enums.ENTITY_TYPE_ENEMY):
			global.gameState.change(enums.STATE_AITURN)
	
	
	
	
	

	
	
	
