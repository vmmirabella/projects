extends "res://scripts/DataObjects/jobs/job.gd"


func _init() : 
	name = "acolyte"
	
	statBoost = {
		enums.ENTITY_HITPOINTS  :  0,
		enums.ENTITY_MANA  :  35,
		enums.ENTITY_SPEED  :  0,
		enums.ENTITY_INTELLECT  :  6,
		enums.ENTITY_DEXTERITY  :  0,
		enums.ENTITY_STRENGTH  :  0,
	}
	
	weapon = {
		enums.JOB_MAINHAND  :  enums.JOB_WEAPON_SYMBOL
	}
	
	armor = {
		enums.JOB_ARMOR :  enums.JOB_ARMOR_CLOTH
	}
	
	magic = {
		"heal" :  {
					enums.JOB_TYPE : enums.JOB_TYPE_LIGHT,
					enums.JOB_DESCRIPTION  :  "Heal an ally",
					enums.JOB_MANA : 10,
					enums.JOB_LEVELREQ : 1,
					enums.JOB_HEAL : 10 
					},
					
		"hymn"  :  {
					enums.JOB_TYPE : enums.JOB_TYPE_LIGHT,
					enums.JOB_DESCRIPTION  :  "Damage an enemy with light",
					enums.JOB_MANA : 15,
		 			enums.JOB_LEVELREQ : 5, 
					enums.JOB_DAMAGE : 10 
					},
					
		"purification" :  {
							enums.JOB_TYPE : enums.JOB_TYPE_LIGHT,
							enums.JOB_DESCRIPTION  :  "Remove status effects from an ally",
							enums.JOB_MANA : 10,
							enums.JOB_LEVELREQ : 3,
							enums.JOB_DAMAGE : 10 
							},
		"rune of protection"  :  {
							enums.JOB_TYPE : enums.JOB_TYPE_DEFENSIVE,
							enums.JOB_DESCRIPTION  :  "Reduce incoming damage on targeted ally",
							enums.JOB_MANA : 20,
							enums.JOB_LEVELREQ : 7,
							enums.JOB_DAMAGE_ABSORB : 15 
							}
	}
