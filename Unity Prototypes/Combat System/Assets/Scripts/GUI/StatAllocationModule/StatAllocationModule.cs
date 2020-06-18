using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class StatAllocationModule
{
    private string[] statNames = new string[6] { "Stamina", "Endurance", "Intellect", "Strength", "Agility", "Resistance" };
    private string[] statDescriptions = new string[6] { "Health Modifier", "Energy Modifier", "Magical Damage modifier", "Physical Damage modifier", "Haste and Crit modifier", "Damage Reduction modifier" };
    private bool[] statSelections = new bool[6]; //toggle switchs

    public int[] pointsToAllocate = new int[6]; //stat values for the chosen class after points are allocated
    private int[] baseStatPoints = new int[6]; //starting stat values for chosen class

    public int availPoints = 5;
    public bool didRunOnce = false;


    public void DisplayStatAllocationModule()
    {

        if (!didRunOnce)
        {
            RetrieveBaseStatPoints();
            didRunOnce = true;
        }

        DisplayStatToggleSwitches();
        DisplayStatIncreaseDecreaseButtons();

    }

    private void DisplayStatToggleSwitches()
    {
        for (int i=0; i < statNames.Length; i++)
        {
            statSelections[i] = GUI.Toggle(new Rect(10,60*i +10,100,50), statSelections[i], statNames[i]);
            GUI.Label(new Rect(100, 60 * i + 10, 50, 50), pointsToAllocate[i].ToString());

            if (statSelections[i]) //display selected descriptions for stats
            {
                GUI.Label(new Rect(20, 60 * i + 10, 150, 100), statDescriptions[i]);
            }

        }

    }


    private void DisplayStatIncreaseDecreaseButtons() 
    {
        for(int i=0; i< pointsToAllocate.Length; i++)
        {
            if (pointsToAllocate[i] >= baseStatPoints[i] && availPoints>0)
            { 
                if(GUI.Button(new Rect(200, 60 * i + 10, 50,50), "+"))
                {
                    pointsToAllocate[i] += 1;
                    --availPoints;
                }
            }

            if (pointsToAllocate[i] > baseStatPoints[i])//only displayed if stat is applied to a specific stat (ie. 1 stat is added to stamina which enables the "-" button to appear)
            {
                if (GUI.Button(new Rect(260, 60 * i + 10, 50, 50), "-"))
                {
                    pointsToAllocate[i] -= 1;
                    ++availPoints;
                }
            }
        }
    }

    private void RetrieveBaseStatPoints()
    {
        BaseCharacterClass cClass = GameInformation.PlayerClass;

        pointsToAllocate[0] = cClass.Stamina;
        baseStatPoints[0] = cClass.Stamina;

        pointsToAllocate[1] = cClass.Endurance;
        baseStatPoints[1] = cClass.Endurance;

        pointsToAllocate[2] = cClass.Intellect;
        baseStatPoints[2] = cClass.Intellect;

        pointsToAllocate[3] = cClass.Strength;
        baseStatPoints[3] = cClass.Strength;

        /*
        pointsToAllocate[4] = cClass.Agility;
        baseStatPoints[4] = cClass.Agility;

        pointsToAllocate[5] = cClass.Resistance;
        baseStatPoints[5] = cClass.Resistance;*/
    }


}

