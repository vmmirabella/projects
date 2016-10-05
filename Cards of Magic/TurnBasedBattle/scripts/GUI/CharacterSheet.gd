
extends Node

var enums = preload("res://scripts/DataObjects/Battle_enums.gd")
var unit #:member unit (Unit): Unit that this Character Sheet is bound to 
var gui = {} #member gui (Dictionary): Dictionary containing references to all of the sub-nodes
var isSelectable = false #member isSelectable (bool): If true, the CharacterSheet can be selected by mouse clicks 
onready var global = get_node("/root/Field") #:member global (Node): Reference to the global object



	
func set_unit(u):
	""" Associates a unit with the Sheet
	
	:param u (Unit): Unit to be bound to the sheet
	"""
	gui["Name"] = get_node("Sheet/Name")
	gui["HealthBar"] =  get_node("Sheet/HealthBar")
	gui["HealthNumber"] =  get_node("Sheet/HealthNumber")
	gui["ManaBar"] = get_node("Sheet/ManaBar")
	gui["ManaNumber"] = get_node("Sheet/ManaNumber")
	gui["ActionPoints"] = get_node("Sheet/ActionPoints")
	
	self.unit = u
	update()
	
func set_string(gui_node_name, s):
	""" Determines the color of the string and then sets the text
	
	:param gui_node_name (string): Name of the node to set
	
	:param s (string): Text to be applied
	""" 
	var type = unit[enums._ENTITY].get_attribute(enums.ENTITY_TYPE)
	
	
	if(type == enums.ENTITY_TYPE_FRIENDLY):
		s = str("[color=aqua]", s, "[/color]")
	elif(type == enums.ENTITY_TYPE_ENEMY):
		s = str("[color=red]", s, "[/color]")
	
	gui[gui_node_name].set_bbcode(s)
	

func update():
	""" Updates the Character sheet to be in-sync with the Unit
	"""
	var total_hitpoints = unit[enums._ENTITY].get_total_hitpoints()
	var total_mana = unit[enums._ENTITY].get_total_mana()
	
	var current_hitpoints = unit[enums._ENTITY].get_current_hitpoints()
	var current_mana = unit[enums._ENTITY].get_current_mana()
	
	var action_points = unit[enums._ENTITY].get_action_points()
		
	gui["HealthBar"].set_val(current_hitpoints/total_hitpoints*100.00)
	
	var s = str("HP: ", current_hitpoints,"/", total_hitpoints)
	
	set_string("HealthNumber", s)
	
	gui["ManaBar"].set_val(current_mana / total_mana * 100.00)
	
	s = str("MP: ", current_mana,"/", total_mana)
	
	set_string("ManaNumber", s)
	
	s = str("ActionPoints: ", action_points)
	
	set_string("ActionPoints", s)
	set_string("Name", unit[enums._ENTITY].get_attribute(enums.ENTITY_NAME))


func _on_Button_pressed():
	""" Set the selected unit if the hidden button on the character sheet is pressed
	
	The function will ignore button presses if it has not been set as selectable
	"""
	if(not isSelectable):
		return
		
	print("panel pressed")
	global.set_selected(unit)
	
func close():
	queue_free()
	
