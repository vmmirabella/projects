extends "res://scripts/DataObjects/jobs/job.gd"


func _init() : 
	name = "rogue"
	
	statBoost = {
		enums.ENTITY_HITPOINTS  :  15,
		enums.ENTITY_MANA  :  0,
		enums.ENTITY_SPEED  :  2,
		enums.ENTITY_INTELLECT  :  0,
		enums.ENTITY_DEXTERITY  :  8,
		enums.ENTITY_STRENGTH  :  2,
	}
	
	
	
	skills = {
		"posion"  :  {
						enums.JOB_TYPE : enums.JOB_TYPE_NATURE,
						 enums.JOB_DESCRIPTION  :  "Shoot a blow dart at an enemy and inflict posion",
						 enums.JOB_COOLDOWN :  3,
						 enums.JOB_LEVELREQ  :  1,
						 enums.JOB_DOT : { 
											enums.JOB_DOT_DURATION : 3 ,
											enums.JOB_DOT_PERTURN : 3,
											enums.JOB_DOT_EFFECT : enums.JOB_DOT_EFFECT_POISON,
											enums.JOB_TYPE : enums.JOB_TYPE_NATURE
										}
					},
		"distract"  :  {
						enums.JOB_TYPE : enums.ENTITY_DEBUFF,
						enums.JOB_DESCRIPTION  :  "Reduce an enemy's damage next turn",
						 enums.JOB_COOLDOWN : 1,
						 enums.JOB_LEVELREQ : 3,
						 enums.JOB_DAMAGE_REDUCTION : 5 
						},
		"shiv" :  {
					enums.JOB_TYPE : enums.JOB_TYPE_PHYSICAL,
					enums.JOB_DESCRIPTION  :  "Swift strike with your dagger",
					 enums.JOB_COOLDOWN : 3,
					 enums.JOB_LEVELREQ : 5,
					 enums.JOB_DAMAGE : 15
					 },
		"invisibility"  :  {
							enums.JOB_TYPE : enums.JOB_TYPE_PHYSICAL,
							enums.JOB_DESCRIPTION  :  "Turn invisible. You cannot take damage from direct attacks for the duration",
							enums.JOB_COOLDOWN : 7,
							enums.JOB_LEVELREQ : 8,
							enums.JOB_TARGET_TYPE :  enums.JOB_TARGET_TYPE_SELF,
							enums.JOB_DOT : { 
											enums.JOB_DOT_DURATION : 3 ,
											enums.JOB_DOT_PERTURN : 3,
											enums.JOB_DOT_EFFECT : enums.JOB_DOT_EFFECT_STEALTH,
											enums.JOB_TYPE : enums.JOB_TYPE_NATURE
										}
							
							}
	}
	
	weapon = {
		enums.JOB_MAINHAND  :  enums.JOB_WEAPON_DAGGER
	}
	
	armor = {
		enums.JOB_ARMOR :  enums.JOB_ARMOR_LEATHER
	}
