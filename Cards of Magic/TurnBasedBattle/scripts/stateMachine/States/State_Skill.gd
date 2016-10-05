extends "res://scripts/stateMachine/States/State.gd"

var ScrollableList = preload("res://scenes/ScrollableList.tscn")
var window = null
var phase = -1
var effect = null
	
func update(delta):
	var pressed = window.get_pressed()
	if(pressed != null && phase < 0):
		phase = 0
		global.effects.add(pressed)
		effect = global.effects.get_effect(pressed).new()
		effect.init(global, global.get_active_unit())
	elif(phase == 0 && effect.onSelectTarget()):
		phase = 1
		effect.onCast()
		global.effects.push(effect)
		global.gameState.change(enums.STATE_ENDTURN)
		
		
		

func onEnter(g):
	.onEnter(g)
	var actionMenu = global.get_action_menu()
	
	window = ScrollableList.instance()
	actionMenu.get_node("..").add_child(window)
	window.init(global)
	window.set_title("Skill Window")
	
	var unit = global.get_active_unit()
	var job = unit[enums._ENTITY].get_attribute(enums.ENTITY_JOB)
	var skills = job.get_skills()
	
	for s in skills:
		global.effects.add(s)
		var e = global.effects.get_effect(s)
		var temp = e.new()
		window.add_button(temp.get_name(), temp.get_description())
	
	window.remove_placeholder_button()

	
func onExit():
	.onExit()
	window.close()