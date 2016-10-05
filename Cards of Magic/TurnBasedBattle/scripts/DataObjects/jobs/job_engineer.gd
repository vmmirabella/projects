extends "res://scripts/DataObjects/jobs/job.gd"


func _init() : 
	name = "engineer"
	
	statBoost = {
		enums.ENTITY_HITPOINTS  :  25.00,
		enums.ENTITY_MANA  :  0,
		enums.ENTITY_SPEED  :  0,
		enums.ENTITY_INTELLECT  :  3,
		enums.ENTITY_DEXTERITY  :  0,
		enums.ENTITY_STRENGTH  :  5,
	}
	
		
	skills = {
		"scattershot"  :  {
							enums.JOB_TYPE : enums.JOB_TYPE_PHYSICAL,
							 enums.JOB_DESCRIPTION  :  "Shoot your pistol at an enemy that also applies a bleed effect",
							 enums.JOB_COOLDOWN :  3,
							 enums.JOB_LEVELREQ  :  3,
							 enums.JOB_DAMAGE : 5,
							 enums.JOB_DOT : {
												enums.JOB_DOT_DURATION : 3 ,
												enums.JOB_DOT_PERTURN : 3,
												 enums.JOB_DOT_EFFECT : enums.JOB_DOT_EFFECT_BLEED,
												 enums.JOB_TYPE : enums.JOB_TYPE_PHYSICAL
											}
						},
		"whack"  :  {
						enums.JOB_TYPE : enums.JOB_TYPE_PHYSICAL,
						enums.JOB_DESCRIPTION  :  "Attempt to stun the enemy",
						enums.JOB_COOLDOWN : 4,
						enums.JOB_LEVELREQ : 8,
						enums.JOB_DAMAGE : 5, 
						"stun_modifier" : 3 
					},
		"grenade" :  {
						enums.JOB_TYPE : enums.JOB_TYPE_PHYSICAL,
						enums.JOB_DESCRIPTION  :  "Throw a grenade to damage all enemies",
						enums.JOB_COOLDOWN : 5,
						enums.JOB_LEVELREQ : 1,
						enums.JOB_DAMAGE : 10 
					},
		"Infuse"  :  {
						enums.JOB_TYPE : enums.JOB_TYPE_EMPOWER ,
						enums.JOB_DESCRIPTION  :  "Infuse a friendly ally to increase their next attack",
						 enums.JOB_COOLDOWN : 3,
						 enums.JOB_LEVELREQ : 5,
						 enums.JOB_DAMAGE_ADDITION : 10 
						}
	}
	
	weapon = {
		enums.JOB_MAINHAND  :  enums.JOB_WEAPON_PISTOL
	}
	
	armor = {
		enums.JOB_ARMOR :  enums.JOB_ARMOR_LEATHER
	}
