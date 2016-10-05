extends Node

#:class: Global object that manages the turn-based battle seaquence.
#:attached: /root/Field

var enums = preload("res://scripts/DataObjects/Battle_enums.gd")
var Entity = preload ( "res://scripts/DataObjects/Entity.gd")
var StateMachine = preload("res://scripts/stateMachine/StateMachine.gd")
var EffectManager = preload ("res://scripts/DataObjects/effects/EffectManager.gd")

var JobManager = preload("res://scripts/DataObjects/jobs/JobManager.gd")
var effects #:member effects (EffectManager): Holds the Effect Manager object
onready var global = get_node("/root/Field")
var Party_Container #:member Party_Container (Node): Holds a reference to the node that will list your party's CharacterSheets
var Enemy_Container  #:member Enemy_Container (Node): Same as Party_Container but for the enemy
var InfoPanel
var active_unit = null  #:member active_unit (Unit): The unit that is taking action.

var gameState  #:member gameState (StateManager): The StateMachine that manages turns and the state of ActionMenu

var units = []  #:member units (Array): Array of all units (friendly and enemy) participating in the battle.

var selected = null  #:member selected (Unit): points to the unit that the user last clicked on


func _ready():
	set_process(true)
	set_process_input(true)
	
	setup_state_machine()
	
	setup_units()	
	
	sort_by_action_points()
	
	setup_gui()
	
	setup_effect_manager()
	
	start_battle()
	
func setup_effect_manager():
	""" Sets up the Effect Manager and initializes it
	
	The function passes global to the Effect Manager
	"""
	effects = EffectManager.new()
	effects.init(global)
	
		
func start_battle():
	""" Puts the first state on to the state machine, starting the battle
	
	The first state is determined by the type of the unit with the most action points
	"""
	
	var active_entity = units[0][enums._ENTITY]
	
	if(active_entity.get_attribute(enums.ENTITY_TYPE) == enums.ENTITY_TYPE_ENEMY):
		gameState.push(enums.STATE_AITURN)
	elif(active_entity.get_attribute(enums.ENTITY_TYPE) == enums.ENTITY_TYPE_FRIENDLY):
		gameState.push(enums.STATE_PLAYERTURN)
	
	
func setup_units():
	""" Fills the units array with dummy data for testing
	
	All units are generated with a random number of action points. However, the action points of units on the friendly team are 
	much higher than that of the enemy. All units are given the conjurer class.
	"""
	var jobs = JobManager.new()
	
	var Tilemap_Objects = get_node("TileMap_Floor/TileMap_Objects")
	var usedTiles = Tilemap_Objects.get_used_cells() #Array of Vector2
	
	var tex_green = ImageTexture.new()
	tex_green.load("res://textures/troll.png")
	
	var tex_red = ImageTexture.new()
	tex_red.load("res://textures/troll_red.png")
	
	
	var offset = Tilemap_Objects.get_pos()
	
	units.resize(usedTiles.size())
	
	for i in range(usedTiles.size()):
		var cell = Tilemap_Objects.get_cellv(usedTiles[i])
		var troll = Sprite.new()
		
		units[i] = { enums._ENTITY : Entity.new() }
		var r = randi() % 50 + 25
		units[i][enums._ENTITY].set_action_points(r)
		
		var entity_type = null
		
		if(cell == 3):
			entity_type = enums.ENTITY_TYPE_FRIENDLY
			troll.set_texture(tex_green)
		elif(cell == 2):
			entity_type = enums.ENTITY_TYPE_ENEMY
			troll.set_texture(tex_red)
			
		var pos = Tilemap_Objects.map_to_world(usedTiles[i]) + offset
		troll.set_pos(pos)
		Tilemap_Objects.add_child(troll)
		
		Tilemap_Objects.set_cellv(usedTiles[i], -1)
		#unit's representation on the tilemap. Includes a reference to the sprite object and tile (x,y) location
		units[i][enums._TILE] = { enums._TILE_LOCATION : usedTiles[i], 	enums._TILE_SPRITE : troll }
		 
		units[i][enums._ENTITY].set_attribute(enums.ENTITY_TYPE, entity_type)
		units[i][enums._ENTITY].set_name(str("Unit #", i))
		units[i][enums._ENTITY].set_attribute(enums.ENTITY_JOB, jobs.get_job(enums.JOB_CONJURER))
		units[i][enums._ENTITY].apply_job_statboost()
		

		
	
func setup_state_machine():
	""" Initializes the state machine
	
	Initializes the state machine and calls add() to load all of the turn states 
	and states from the action menu.
	"""
	gameState = StateMachine.new()
	gameState.init(global)
	gameState.add(enums.STATE_AITURN)
	gameState.add(enums.STATE_PLAYERTURN)	
	gameState.add(enums.STATE_ATTACK)	
	gameState.add(enums.STATE_DEFEND)	
	gameState.add(enums.STATE_ITEM)	
	gameState.add(enums.STATE_SKILL)
	gameState.add(enums.STATE_MAGIC)	
	gameState.add(enums.STATE_ENDTURN)
	gameState.add(enums.STATE_UNITSELECTED)
		
	
		
func setup_gui():
	""" Sets up the battle GUI
	
	Adds references to all of the GUI container nodes and associates a CharacterSheet with the
	coresponding unit. 
	"""
	Party_Container = get_node("/root/Field/GUI/Party")
	Enemy_Container = get_node("/root/Field/GUI/Enemy")
	InfoPanel = get_node("/root/Field/GUI/InfoPanel/Text")
		
	InfoPanel.set_scroll_follow(true)	
		
	
func get_units():
	""" Gets the units array
	
	:returns value (array): Returns the unit array 
	"""
	return units
	
func sort_by_action_points():
	""" Sorts the unit array by action points.
	
	Does a custom sort by calling sort_by_action_points() in the Entity class
	"""
	
	units.sort_custom(units[0][enums._ENTITY], "sort_by_action_points")
	

func _process(delta):
	""" Updates the state machine and CharacterSheets for all units
	
	:param delta (float): Time since last frame
	
	"""
		
	gameState.update(delta)
	
func _input(event):
	gameState.input(event)
	

func set_info_text(bbcode_text, boolAppend):
	""" Displays text in the combat log
	
	:param bbcode_text (String): BBCode text to be displayed
	
	:param boolAppend (Bool): If true, will append text to the combat log. 
	If false, will clear the log and then append the BBCode text.
	"""
	if(boolAppend):
		InfoPanel.append_bbcode(bbcode_text)
		InfoPanel.newline()	
	else:
		InfoPanel.set_bbcode(bbcode_text)
		
		
func set_selected(u):
	""" Marks the unit as selected
	
	:param u (Unit): Unit to be marked as selected
	"""
	selected = u

func get_selected():
	""" Returns the selected unit
	
	:returns value (Unit): The selected unit or null if none selected
	"""
	return selected
	

func deselect():
	""" Sets the selected unit to a null value
	
	"""
	selected = null
		
func get_action_menu():
	""" Returns a reference to the Action Menu node
	
	:returns value (node): Reference to the action menu node
	"""
	return get_node("GUI/ActionMenu")
	
func create_action_menu():
	""" Creates the Action Menu scene 
	"""
	
	var Menu = load("res://scenes/ActionMenu.tscn")
	var ActionMenu = Menu.instance()
	var GUI = get_node("GUI")
	GUI.add_child(ActionMenu)
	ActionMenu.init(global) 

func destroy_action_menu():
	""" Destroys the Action Menu scene 
	"""
	
	get_action_menu().queue_free()
	
func set_active_unit(u):
	""" Sets the current active unit
	:param u (Unit): Unit to be set as active
	
	"""
	active_unit = u
		
func get_active_unit():
	""" Returns the current active unit
	
	:returns value (Unit): Returns the current active unit (aka the unit currently taking a turn) or null
	"""
	
	return active_unit	
	
func get_camera():
	""" Returns the camera node
	
	:returns value (Unit): Returns the camera node
	"""
	
	return get_node("Camera2D")
	