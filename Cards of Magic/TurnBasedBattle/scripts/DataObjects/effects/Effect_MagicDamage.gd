extends "res://scripts/DataObjects/effects/Effect.gd"


func onCast():
	primaryStat = get_primary_stat_for_damage()
	damage = get_damage()
	cost = {"cost_type": "magic", "cost_value":get_cost()} #:todo: need to make an enum?	
	if(job.magic[name].has(enums.JOB_DOT)):
		dot = job.magic[name][enums.JOB_DOT] 
	.onCast()

func onSelectTarget():
	var type = job.magic[name][enums.JOB_TARGET_TYPE]
	
	if(type == enums.JOB_TARGET_TYPE_SINGLE):
		return .target_single()
		

func get_description():
	return job.magic[name][enums.JOB_DESCRIPTION]
	
func get_name():
	return name

func get_level_requirement():
	return job.magic[name][enums.JOB_LEVELREQ]
	
func get_type():
	return job.magic[name][enums.JOB_TYPE]
	
	
func get_primary_stat_for_damage():
	return job.magic[name][enums.JOB_PRIMARYSTAT]
	
func get_damage():
	return job.magic[name][enums.JOB_DAMAGE]

func get_cost():
	return job.magic[name][enums.JOB_MANA]
