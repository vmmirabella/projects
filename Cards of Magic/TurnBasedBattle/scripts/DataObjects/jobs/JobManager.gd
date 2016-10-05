extends Object
var enums = preload("res://scripts/DataObjects/Battle_enums.gd")


var jobs ={} #:member jobs (Dictionary): Dictionary of loaded job scripts

func _init():
	""" Loads job scripts
	
	Loads job scripts using the JOBS dictionary mapping found in enums
	""" 
	var path = "res://scripts/DataObjects/jobs/job_"
	var keys = enums.JOB.keys()
	for k in keys:
		var obj = load(str(path,enums.JOB[k],".gd"))
		jobs[k] = obj
		
func get_job(job_name):
	""" Returns the instansiated job
	"""
	return jobs[job_name].new()
