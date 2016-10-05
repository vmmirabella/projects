
extends Node

var scenes = {
"Battlefield" : "field.tscn"

}
onready var buttons = get_node("Panel/VButtonArray")

func _ready():
	var path = "res://scenes"
	var keys = scenes.keys()
	
	for k in keys:
		buttons.add_button(k)




func _on_VButtonArray_button_selected( button ):
	var name = buttons.get_button_text(button)
	var path = "res://scenes/"
	
	print(str("Changing to ", scenes[name]))
	
	get_tree().change_scene(str(path,scenes[name]))	
	
