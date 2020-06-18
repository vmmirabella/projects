using System.Collections;
using System.Collections.Generic;
using UnityEngine;

//base for all items/equipment/weapons that will contain any type of stats
[System.Serializable]
public class BaseStatItem : BaseItem
{
    private int stamina;
    private int endurance;
    private int strength;
    private int intellect;
    private int overpower;
    private int luck;
    private int mastery;
    private int charisma;

    public int Stamina { get => stamina; set => stamina = value; }
    public int Endurance { get => endurance; set => endurance = value; }
    public int Strength { get => strength; set => strength = value; }
    public int Intellect { get => intellect; set => intellect = value; }
    public int Overpower { get => overpower; set => overpower = value; }
    public int Luck { get => luck; set => luck = value; }
    public int Mastery { get => mastery; set => mastery = value; }
    public int Charisma { get => charisma; set => charisma = value; }
}
