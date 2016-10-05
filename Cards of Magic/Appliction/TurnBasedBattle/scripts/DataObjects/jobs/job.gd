extends Object

var enums = preload("res://scripts/DataObjects/Battle_enums.gd")

var magic = null #:member magic (Dictionary): List of magic spells 
var skills = null #:member skills (Dictionary): List of skills
var requirements = null #:member requirements (Dictionary): Requirements to obtain this job
var weapon = null #:member weapon (Dictionary): Primary and offhand type of weapon used by this job.
var armor = null #:member armor (Dictionary): Type of armor used by this job
var statBoost = {} #:member statBoost (Dictionary): Boost to apply after this job has been obtained
var name = "undefined" #:member name (string): Name of the job class
var level = 1 #:member level (int): current level of the job