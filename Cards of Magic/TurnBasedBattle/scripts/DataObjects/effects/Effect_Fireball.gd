extends "res://scripts/DataObjects/effects/Effect.gd"

var turns = 3
var target = null

var selectingPhase = -1

func init(g, o):
	.init(g, o)
	

func onCast():
	target[enums._ENTITY].apply_damage(5)
	var s = str(origin[enums._ENTITY].get_name(),"'s Fireball does 5 damage to ", target[enums._ENTITY].get_name(), " and inflicts burning")
	
	global.set_info_text(s, true)

func onSelectTarget():
	
	if(selectingPhase == -1):
		
		#make enemies selectable
		var units = global.get_units()
		
		for u in units:
			if(u[enums._ENTITY].get_attribute(enums.ENTITY_TYPE) == u[enums._ENTITY].TYPE_ENEMY):
				u[enums._GUI].set_selectable(true)
				
		global.set_info_text("Select a target for Fireball", true)
		global.deselect()
		selectingPhase = 0
	elif(selectingPhase == 0):
		var selected = global.get_selected()
		
		if(selected != null):
			global.set_info_text(str("Selected ", selected[enums._ENTITY].get_name()), true)
			target = selected
			selectingPhase = 1
			#turn selection off
			var units = global.get_units()
			
			for u in units:
				if(u[enums._ENTITY].get_attribute(enums.ENTITY_TYPE) == u[enums._ENTITY].TYPE_ENEMY):
					u[enums._GUI].set_selectable(false)
			return true
		
	return false		
		
	
func onStartTurn():
	if(turns != 0):
		target[enums._ENTITY].apply_damage(3)
		var s = str("Burning effect does 3 damage to ", target[enums._ENTITY].get_name())
	
		global.set_info_text(s, true)
		turns = turns - 1
	
	return turns == 0
	
func onEndTurn():
	pass
	
func get_description():
	var s ="Causes 5 HP of damage to 1 target and a burning DOT that does 3 HP of damage per turn and lasts 3 turns."
	return s
	
func get_name():
	return "Fireball"
	
func add_to_manager():
	global.effects.add(get_name())
	global.effects.onSelectTarget(get_name(), origin)