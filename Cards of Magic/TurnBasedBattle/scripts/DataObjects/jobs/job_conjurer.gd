extends "res://scripts/DataObjects/jobs/job.gd"


func _init() : 

	name = "conjurer"
	
	statBoost = {
		enums.ENTITY_HITPOINTS  :  0,
		enums.ENTITY_MANA  :  45,
		enums.ENTITY_SPEED  :  0,
		enums.ENTITY_INTELLECT  :  5,
		enums.ENTITY_DEXTERITY  :  2,
		enums.ENTITY_STRENGTH  :  0,
	}
	
	skills = null
	
	weapon = {
		enums.JOB_MAINHAND  :  enums.JOB_WEAPON_STAFF
	}
	
	armor = {
		enums.JOB_ARMOR :  enums.JOB_ARMOR_CLOTH
	}
	
	magic = {
		"fire" :  {
					enums.JOB_TYPE : enums.JOB_TYPE_FIRE,
					enums.JOB_DESCRIPTION  :  "Cast fire on the enemy",
					enums.JOB_MANA : 25,
					enums.JOB_LEVELREQ : 1,
					enums.JOB_DAMAGE : 10,
					enums.JOB_TARGET_TYPE :  enums.JOB_TARGET_TYPE_SINGLE,
					enums.JOB_PRIMARYSTAT  :  enums.ENTITY_INTELLECT
					},
		"water" :  {
					enums.JOB_TYPE : enums.JOB_TYPE_WATER,
					enums.JOB_DESCRIPTION  :  "Cast water on the enemy",
					enums.JOB_MANA : 15,
					enums.JOB_LEVELREQ : 8,
					enums.JOB_DAMAGE : 15 
					},
		"earth" :  {
					enums.JOB_TYPE : enums.JOB_TYPE_EARTH,
					enums.JOB_DESCRIPTION  :  "Cast earth on the enemy",
					enums.JOB_MANA : 10,
					enums.JOB_LEVELREQ : 3,
					enums.JOB_DAMAGE : 10,
					enums.JOB_TARGET_TYPE :  enums.JOB_TARGET_TYPE_SINGLE,
					enums.JOB_PRIMARYSTAT  :  enums.ENTITY_INTELLECT,
					enums.JOB_DOT : {
												enums.JOB_DOT_DURATION : 3,
												enums.JOB_DOT_PERTURN : 3,
												enums.JOB_DOT_EFFECT : enums.JOB_DOT_EFFECT_BLEED,
												enums.JOB_TYPE : enums.JOB_TYPE_PHYSICAL
											}
					},
		"air" :  {
					enums.JOB_TYPE : enums.JOB_TYPE_AIR,
					enums.JOB_DESCRIPTION  :  "Cast air on the enemy",
					enums.JOB_MANA : 20,
					enums.JOB_LEVELREQ : 5,
					enums.JOB_DAMAGE : 20 
					},
	}

func get_skills() : 
	return skills
	
func get_magic() : 
	return magic
