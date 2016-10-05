
extends VBoxContainer

var enums = preload("res://scripts/DataObjects/Battle_enums.gd")
var global
var pressed

func init(global):
	self.global = global
	

func _on_AttackButton_pressed():
	pressed = enums.ACTIONMENU_ATTACK
	
	global.gameState.push(enums.STATE_ATTACK)
		
	


func _on_DefendButton_pressed():
	pressed = enums.ACTIONMENU_DEFEND
	global.gameState.push(enums.STATE_DEFEND)


func _on_ItemsButton_pressed():
	pressed = enums.ACTIONMENU_ITEM
	global.gameState.push(enums.STATE_ITEM)
	
func get_pressed():
	return pressed
	
func clear_pressed():
	pressed = enums.ACTIONMENU_NONE

func _on_SkillButton_pressed():
	pressed = enums.ACTIONMENU_SKILL
	global.gameState.push(enums.STATE_SKILL)


func _on_MagicButton_pressed():
	pressed = enums.ACTIONMENU_MAGIC
	global.gameState.push(enums.STATE_MAGIC)
	

