extends Object

var effects = {}
var global


func init(g):
	""" Passes global object for storage
	
	:param g (Node): Reference to global object
	""" 
	self.global = g

func add(effect_name):
	""" Loads an Effect script
	
	:param effect_name (string): Effect name
	""" 
	var path = "res://scripts/DataObjects/effects/Effect_"
	
	if(!effects.has(effect_name)):
		effects[effect_name] = load(str(path, effect_name,".gd"))
		
func get_effect(effect_name):
	""" Passes back a reference to the loaded Effect script
	
	:param effect_name (string): Effect name
	""" 
	if(effect_name in effects):
		return effects[effect_name]
		
	return null