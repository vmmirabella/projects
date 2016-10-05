extends Object

var enums = preload("res://scripts/DataObjects/Battle_enums.gd")
var global #:member global (node): Reference to global object 
var origin #:member origin (Unit): Unit who cast the effect
var level = 1 #:member level (int): Level requirement of the effect
var name #:member name (string): Name of the effect
var job #:member job (Job): Job of the origin
var selectingPhase = -1 #:member selectingPhase (int): Phase of target selection
var turn = 0 #:member turn (int): number of turns that the DOT will last
var target = null #:member target (Unit): Target of the effect
var primaryStat #:member primaryStat (enum): enum value of the primary stat of the effect
var damage #:member damage (int): Flat damage that the effect will inflict
var cost #:member cost (int): Mana cost of the effect
var canCast = false #:member canCast (bool): True if the Entity has enough mana to cast the spell
var dot = null #:member dot (Dictionary): Contains the dot information of the effect

func init(g, o, name):
	""" Sets the global object, origin and name of the effect
	
	The init() is called by the derived class. the Effect script is not intended to be used on its own
	
	:param g (Node): Reference to the global object
	
	:param o (Unit): Origin of the spell
	
	:param name (string): Name of the effect
	"""
	
	self.global = g
	self.origin = o
	self.name = name
	job = origin[enums._ENTITY].get_attribute(enums.ENTITY_JOB)

func onCast():
	""" Called when the effect is cast
	"""
	
	if (cost["cost_type"] == "magic" && origin[enums._ENTITY].use_mana(cost["cost_value"])):
		canCast = true
	elif(cost["cost_type"] == "cooldown"):
		canCast = false
	
	if (canCast):
		var stat = origin[enums._ENTITY].get_attribute(primaryStat)
		var origin_debuff = origin[enums._ENTITY].get_attribute(enums.ENTITY_DEBUFF)
		var origin_buff = origin[enums._ENTITY].get_attribute(enums.ENTITY_BUFF)
		var target_debuff = target[enums._ENTITY].get_attribute(enums.ENTITY_DEBUFF)
		var target_buff = target[enums._ENTITY].get_attribute(enums.ENTITY_BUFF)
		
	
		if(origin_debuff != null && origin_debuff.has(enums.JOB_STAT_REDUCTION) && origin_debuff[enums.JOB_STAT_REDUCTION][enums.JOB_PRIMARYSTAT] == primaryStat):
			stat = stat - origin_debuff[enums.JOB_STAT_REDUCTION][enums.JOB_VALUE]
		
		if(origin_buff != null && origin_buff.has(enums.JOB_STAT_ADDITION) && origin_buff[enums.JOB_STAT_ADDITION][enums.JOB_PRIMARYSTAT] == primaryStat):
			stat = stat + origin_buff[enums.JOB_STAT_ADDITION][enums.JOB_VALUE]
	
		damage = damage + stat
		
		if(origin_debuff != null && origin_debuff.has(enums.JOB_DAMAGE_REDUCTION)):
			damage = damage - origin_debuff[enums.JOB_DAMAGE_REDUCTION]
		if(origin_buff != null && origin_buff.has(enums.JOB_DAMAGE_ADDITION)):
			damage = damage + origin_debuff[enums.JOB_DAMAGE_ADDITION]
		
		var bbcode_text = str(origin[enums._ENTITY].get_name(), " casts ", name, " on ")
		bbcode_text = str(bbcode_text, target[enums._ENTITY].get_name(), " and does ", damage, " points of damage")
		
		global.set_info_text(bbcode_text, true)
		target[enums._ENTITY].apply_damage(damage)
			
		print ("dot is ", dot)
		print(name)
		print(dot[enums.JOB_DOT_DURATION])
		print(dot[enums.JOB_DOT_PERTURN])
		print(dot[enums.JOB_DOT_EFFECT])
		print(dot[enums.JOB_TYPE])		
		#:todo: needs to be fixed
		if(dot !=null):
			#:todo: job.magic[name].....needs to be changed
			if(job.magic[name][enums.JOB_TARGET_TYPE] == enums.JOB_TARGET_TYPE_SINGLE):
				target[enums._ENTITY].apply_dot(dot)
	
		
	
func onSelectTarget():
	""" Called when selecting target(s) for the effect
	"""
	pass
	
func onStartTurn():
	""" Called by PlayerTurn or AITurn during onEnter()
	"""
	return false
	
func get_description():
	""" Description of the effect
	
	:returns value (string): Description of the effect
	"""
	pass
	
func get_type():
	""" Type of the effect
	
	:returns value (enum): Type of the effect
	"""
	pass
	
func get_name():
	""" Name of the effect
	
	:returns value (string):Name of the effect
	"""
	return "Effect"

func get_level_requirement():
	""" Level Requirement of the effect
	
	:returns value (int): Level requirement of the effect
	"""
	return level

func get_turn():
	""" Number of turns left for the effect
	:returns value (int): Number of turns left for the effect
	
	:todo: I think this is depreciated anmd no longer used. This includes the "turn" variable
	"""
	return turn
	
func get_primary_stat_for_damage():
	""" Primary Stat of the effect
	
	:returns value (enum): Primary Stat of the effect
	"""
	pass

func target_single():
	""" Targets a single Unit 
	
	Targets a single unit and called when Target Type is set to Single
	
	:todo: Currently this has been changed to target both friendly and enemy for testing. 
	May want to change it to just enemy if we add more specfic target types 
	
	:returns value (bool): True if target has been selected. False otherwise.
	"""
	if(selectingPhase == -1):
		
		#make enemies selectable
		var units = global.get_units()
				
		global.set_info_text(str("Select a target for ", name), true)
		global.deselect()
		selectingPhase = 0
	elif(selectingPhase == 0):
		var selected = global.get_selected()
		
		if(selected != null):
			global.set_info_text(str("Selected ", selected[enums._ENTITY].get_name()), true)
			target = selected
			selectingPhase = 1

			return true
		
	return false
	