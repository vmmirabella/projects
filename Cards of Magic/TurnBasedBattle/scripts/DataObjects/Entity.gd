extends Object

#:class: The Entity object which serves as the base for all characters

var enums = preload("res://scripts/DataObjects/Battle_enums.gd")

var attr = {
	enums.ENTITY_ID : -1,
	enums.ENTITY_NAME : "undefined",
	enums.ENTITY_HITPOINTS : { enums.ENTITY_HITPOINTS_CURRENT : 77.00, enums.ENTITY_HITPOINTS_TOTAL : 100.00 },
	enums.ENTITY_MANA : { enums.ENTITY_MANA_CURRENT : 77.00, enums.ENTITY_MANA_TOTAL : 100.00 },
	enums.ENTITY_SPEED : 10,
	enums.ENTITY_INTELLECT : 10,
	enums.ENTITY_DEXTERITY : 10,
	enums.ENTITY_STRENGTH : 10,
	enums.ENTITY_TYPE : enums.ENTITY_TYPE_NONE,
	enums.ENTITY_ACTION_POINTS :  100.00,
	enums.ENTITY_JOB : null,
	enums.ENTITY_DEBUFF : { enums.JOB_DOT : [] },
	enums.ENTITY_BUFF : null,
	enums.ENTITY_LEVEL : 3,
	enums.ENTITY_EXP : {enums.ENTITY_EXP_CURRENT:0, enums.ENTITY_EXP_TOTAL: 100},
	enums.ENTITY_MOVE : { enums.ENTITY_HAS_MOVED : false, enums.ENTITY_MOVE_RANGE : 2 }, #:todo: Lower movement range to 4
	enums.ENTITY_ENDTURN : false
	
} #:member attr (Dictionary): A dictionary of Entity attributes

func set_id(id):
	""" Sets the ID of the Entity
	
	Currently this isn't used for anything. We might want to depreciate this.
	
	:param id (int): ID to be set
	
	:todo: Remove this function?
	"""
	attr[enums.ENTITY_ID] = id
	
func get_id(id):
	""" Gets the ID of the Entity
	
	Currently this isn't used for anything. We might want to depreciate this.
	
	:returns id (int): ID to be returned
	
	:todo: Remove this function?
	"""
	attr[enums.ENTITY_ID] = id

func get_name():
	""" Gets the name of the Entity
	
	:returns name (string): name to be returned
	"""
	return attr[enums.ENTITY_NAME]

func set_name(name):
	""" Sets the name of the Entity
	"""
	attr[enums.ENTITY_NAME] = name
	
func get_current_hitpoints():
	""" Gets the current hit points of the Entity
	
	:returns current hitpoints (int): hitpoints to be returned
	"""
	return attr[enums.ENTITY_HITPOINTS][enums.ENTITY_HITPOINTS_CURRENT]
	
func get_current_mana():
	""" Gets the current hit points of the Entity
	
	:returns current hitpoints (int): hitpoints to be returned
	"""
	return attr[enums.ENTITY_MANA][enums.ENTITY_MANA_CURRENT]
	
func get_total_hitpoints():
	""" Gets the total hit points of the Entity
	
	:returns total hitpoints (int): hitpoints to be returned
	"""
	return attr[enums.ENTITY_HITPOINTS][enums.ENTITY_HITPOINTS_TOTAL]
	
func get_total_mana():
	""" Gets the total mana of the Entity
	
	:returns total mana (int): total mana to be returned
	"""
	return attr[enums.ENTITY_MANA][enums.ENTITY_MANA_TOTAL]
	

func get_attribute(attribute_name):
	""" Gets the specified key from the attr dictionary
	
	:param attribute_name (enum): Key of value to be retrieved
	
	:returns value (Dictionary Value): value to be returned
	"""
	
	return attr[attribute_name]
	
func set_attribute(attribute_name, attribute_value):
	""" Sets the specified key and value from the attr dictionary
	
	:param attribute_name (int): Key of value to be set
	
	:param attribute_value (any): Value to be set
	
	"""
	attr[attribute_name] = attribute_value
	
func apply_damage(amount):
	""" Reduces the Entity's HP by the specfied amount
	
	:param amount (int): amount to decrease HP by
	
	"""
	
	if(attr[enums.ENTITY_HITPOINTS][enums.ENTITY_HITPOINTS_CURRENT] - amount < 0):
		attr[enums.ENTITY_HITPOINTS][enums.ENTITY_HITPOINTS_CURRENT] = 0
	else:
		attr[enums.ENTITY_HITPOINTS][enums.ENTITY_HITPOINTS_CURRENT] = attr[enums.ENTITY_HITPOINTS][enums.ENTITY_HITPOINTS_CURRENT] - amount
		
	
func use_mana(amount):
	""" Reduces the Entity's mana by the specfied amount
	
	:param amount (int): amount to decrease mana by
	
	:returns value (bool): Returns true if the specified amount could be removed. False otherwise.
	"""
	
	if(attr[enums.ENTITY_MANA][enums.ENTITY_MANA_CURRENT] - amount < 0):
		return false
	
	attr[enums.ENTITY_MANA][enums.ENTITY_MANA_CURRENT] = attr[enums.ENTITY_MANA][enums.ENTITY_MANA_CURRENT] - amount
	return true
	
func get_action_points():
	""" Get the Entity's action points

	:returns value (int): Returns the number of action points.
	"""
	return attr[enums.ENTITY_ACTION_POINTS]
		
func set_action_points(amount):
	""" Set the Entity's action points

	:param amount (int): Amount of action points.
	"""
	
	attr[enums.ENTITY_ACTION_POINTS] = amount
	
func sort_by_action_points(a, b):
	""" Compare A and B's action points

	:param a (unit): Unit to be compared
	
	:param b (unit): Unit to be compared
	
	:returns value (bool): Returns true if a > b. False otherwise
	"""
	var a_action = a[enums._ENTITY].get_action_points()
	var b_action = b[enums._ENTITY].get_action_points()

	return a_action > b_action	

func get_job():
	""" Returns a job object

	:returns value (Job): Returns a job object
	"""
	return attr[enums.ENTITY_JOB]
	
func apply_job_statboost():
	""" Applys the job's stat boost
	
	Set a job object using set_attribute(). Then call this function to apply stat boots
	"""
	var job = get_job()
	
	attr[enums.ENTITY_HITPOINTS][enums.ENTITY_HITPOINTS_TOTAL] += job.statBoost[enums.ENTITY_HITPOINTS]
	attr[enums.ENTITY_MANA][enums.ENTITY_MANA_TOTAL] += job.statBoost[enums.ENTITY_MANA]
	attr[enums.ENTITY_SPEED] += job.statBoost[enums.ENTITY_SPEED]
	attr[enums.ENTITY_INTELLECT] += job.statBoost[enums.ENTITY_INTELLECT]
	attr[enums.ENTITY_DEXTERITY] += job.statBoost[enums.ENTITY_DEXTERITY]
	attr[enums.ENTITY_STRENGTH] += job.statBoost[enums.ENTITY_STRENGTH]
	
func get_level():
	""" Returns the Entity's level
	
	:returns value (int): Returns the Entity's level
	"""
	return attr[enums.ENTITY_LEVEL]

func apply_dot(dot):
	""" Adds DOT to the debuff array
	
	:param dot (Dictionary): Dictionary of a dot to be added  
	"""
	attr[enums.ENTITY_DEBUFF][enums.JOB_DOT].push_front(dot)