extends "res://scripts/DataObjects/jobs/job.gd"


func _init() : 
	name = "squire"
	
	
	statBoost = {
		enums.ENTITY_HITPOINTS  :  50.00,
		enums.ENTITY_MANA  :  0,
		enums.ENTITY_SPEED  :  0,
		enums.ENTITY_INTELLECT  :  0,
		enums.ENTITY_DEXTERITY  :  0,
		enums.ENTITY_STRENGTH  :  5,
	}
	
	skills = {
		"guard"  :  {
					enums.JOB_TYPE : enums.JOB_TYPE_DEFENSIVE,
					enums.JOB_DESCRIPTION  :  "Protects another character from damage this turn",
					enums.JOB_COOLDOWN :  3,
					enums.JOB_LEVELREQ  :  1,
					enums.JOB_DAMAGE_ABSORB : 55,
					enums.JOB_DAMAGE_TAKEN : enums.JOB_INCOMING_DAMAGE
					},
		"crash"  :  {
					enums.JOB_TYPE : enums.JOB_TYPE_PHYSICAL,
					enums.JOB_DESCRIPTION  :  "Crash into an enemy and do extra damage",
					 enums.JOB_COOLDOWN : 5,
					 enums.JOB_LEVELREQ : 3,
					 enums.JOB_DAMAGE : 10 
					},
		"parry" :  {
					enums.JOB_TYPE : enums.JOB_TYPE_DEFENSIVE,
					enums.JOB_DESCRIPTION  :  "Deflect an incoming attack and do damage to the attacker",
					enums.JOB_COOLDOWN : 2,
					enums.JOB_LEVELREQ : 5,
					enums.JOB_DAMAGE_ABSORB : 15,
					enums.JOB_DAMAGE : 5 
					},
		"outburst"  :  {
						enums.JOB_TYPE : enums.JOB_TYPE_PHYSICAL,
						enums.JOB_DESCRIPTION  :  "Swing at an opponent with force",
						enums.JOB_COOLDOWN : 5,
						enums.JOB_LEVELREQ : 8,
						enums.JOB_DAMAGE : 35 
						}
	}
	
	weapon = {
		enums.JOB_MAINHAND  :  enums.JOB_WEAPON_SWORD
	}
	
	armor = {
		enums.JOB_ARMOR :  enums.JOB_ARMOR_CHAINMAIL
	}