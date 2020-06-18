using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class DisplayCreatePlayerFunctions
{
    private int classSelection;
    private string[] classSelectionNames = new string[] { "Mage", "Warrior", "Archer", "Rogue", "Warlock", "Paladin" };
    private string playerFirstName = "Enter First Name";
    private string playerLastName = "Enter Last Name";
    private string playerBio = "Enter player Bio";
    private int genderSelection;
    private string[] genderTypes = new string[2] {"Male", "Female" };

    private StatAllocationModule statAllocationModule = new StatAllocationModule();
   


    public void DisplayClassSelections()
    {
        //a list of toggle buttons and each button will be a different class
        //selection grid shows classes
        classSelection = GUI.SelectionGrid(new Rect(50,50,250,300), classSelection, classSelectionNames, 2); //(size of each cell, item currently selected, names to be displayed, # per row)
        GUI.Label(new Rect(450, 50, 300, 300), FindClassDescription(classSelection));
        GUI.Label(new Rect(450, 100, 300, 300), FindClassStatValues(classSelection));
        
    }

    private string FindClassDescription(int classSelection)
    {
        BaseCharacterClass tempClass;

        if (classSelection == 0)
        {
            tempClass = new BaseMageClass();
            return tempClass.ClassDescription;
        }
        else if (classSelection == 1)
        {
            tempClass = new BaseWarriorClass();
            return tempClass.ClassDescription;
        }

        return "Select a Class";
    }

    private string FindClassStatValues(int classSelection)
    {
        BaseCharacterClass tempClass;

        if (classSelection == 0)
        {
            tempClass = new BaseMageClass();
            string tempStats = "Stamina " + tempClass.Stamina + "\n" + "Endurance " + tempClass.Endurance;
            return tempStats;
        }
        else if (classSelection == 1)
        {
            tempClass = new BaseWarriorClass();
            string tempStats = "Stamina " + tempClass.Stamina + "\n" + "Endurance " + tempClass.Endurance;
            return tempStats;
        }

        return "No Stats Found";
    }

    //stat allocation state
    public void DisplayStatAllocation()
    {
        //list of stats with plus and minus buttons to add stats
        //logic to make sure the player cannot add more than X stats given
        statAllocationModule.DisplayStatAllocationModule();
    }

    public void DisplayFinalSetup()
    {
        //name
        playerFirstName = GUI.TextArea(new Rect(20,10,150,25), playerFirstName, 25);
        playerLastName = GUI.TextArea(new Rect(20, 55, 150, 25), playerLastName, 25);

        //bio
        playerBio = GUI.TextArea(new Rect(20, 90, 250, 200), playerBio, 255);

        //gender
        genderSelection = GUI.SelectionGrid(new Rect(220, 10, 100,70), genderSelection, genderTypes, 1);

        //add a description to your character 




    }

    //save class information that the user has chosen
    private void ChooseClass(int classSelection)
    {
        if (classSelection == 0)
        {
            GameInformation.PlayerClass = new BaseMageClass();
        }
        else if (classSelection == 1)
        {
            GameInformation.PlayerClass = new BaseWarriorClass();
        }
    }


    //displays items that will be shown on each scene 
    //(ie. Starts with class selection -> stat allocation -> finalize) 
    //each "scene" will ALWAYS display any GUI elements in this function
    public void DisplayMainItems()
    {

        Transform player = GameObject.FindGameObjectWithTag("Player").transform;

        GUI.Label(new Rect(Screen.width / 2, 20, 250, 250), "CREATE NEW PLAYER"); //Title


        //Rotation buttons to rotate player model
        if(GUI.RepeatButton(new Rect(340,370,50,50), "<<<")) 
        {
            //turn transform tagged as player to the left
            player.Rotate(Vector3.up * 10 * Time.deltaTime);
        }
        if (GUI.RepeatButton(new Rect(470, 370, 50, 50), ">>>"))
        {
            //turn transform tagged as player to the right
            player.Rotate(Vector3.down * 10 * Time.deltaTime);
        }

        //button logic to change states going forward using NEXT and ending in Finish
        if (CreateAPlayerGUI.currentState != CreateAPlayerGUI.CreateAPlayerStates.FINALSETUP)//displays "NEXT" button if the current state isn't final setup
        { 
            if (GUI.Button(new Rect(570, 370, 70, 50), "NEXT")) //button to go onto the next create a player state
            {
                if (CreateAPlayerGUI.currentState == CreateAPlayerGUI.CreateAPlayerStates.CLASSSELECTION)
                {
                    CreateAPlayerGUI.currentState = CreateAPlayerGUI.CreateAPlayerStates.STATALLOCATION;
                    ChooseClass(classSelection);
                }
                else if (CreateAPlayerGUI.currentState == CreateAPlayerGUI.CreateAPlayerStates.STATALLOCATION)
                {
                    //save all new stats that have been allocated by the player in the gameinformation object
                    GameInformation.Stamina = statAllocationModule.pointsToAllocate[0];
                    GameInformation.Endurance =  statAllocationModule.pointsToAllocate[1];
                    GameInformation.Intellect = statAllocationModule.pointsToAllocate[2];
                    GameInformation.Strength = statAllocationModule.pointsToAllocate[3];
                   /* GameInformation.Agility = statAllocationModule.pointsToAllocate[4];
                    GameInformation.Resistance = statAllocationModule.pointsToAllocate[5];*/

                    CreateAPlayerGUI.currentState = CreateAPlayerGUI.CreateAPlayerStates.FINALSETUP;

                }
            }
        } else if (CreateAPlayerGUI.currentState == CreateAPlayerGUI.CreateAPlayerStates.FINALSETUP)// displays the "FINISH" button if the current state is in the final setup
        {
            if (GUI.Button(new Rect(570, 370, 70, 50), "FINISH"))
            {
                GameInformation.PlayerName = playerFirstName + " " + playerLastName;
                GameInformation.PlayerBio = playerBio;
                if (genderSelection == 0)
                {
                    GameInformation.IsMale = true;
                }
                else if (genderSelection == 1)
                {
                    GameInformation.IsMale = false;
                }
                SaveInformation.SaveAllInformation();
            }
        }

        //button logic to change states going backwards
        if (CreateAPlayerGUI.currentState != CreateAPlayerGUI.CreateAPlayerStates.CLASSSELECTION)//display "BACK" button in every state except the first one (CLASS SELECTION)
        { 
            if (GUI.Button(new Rect(270, 370, 70, 50), "BACK")) 
            {
                if (CreateAPlayerGUI.currentState == CreateAPlayerGUI.CreateAPlayerStates.STATALLOCATION)
                {
                    statAllocationModule.didRunOnce = false;
                    GameInformation.PlayerClass = null;
                    statAllocationModule.availPoints = 5;
                    CreateAPlayerGUI.currentState = CreateAPlayerGUI.CreateAPlayerStates.CLASSSELECTION;
              
                }
                else if (CreateAPlayerGUI.currentState == CreateAPlayerGUI.CreateAPlayerStates.FINALSETUP)
                {
                    CreateAPlayerGUI.currentState = CreateAPlayerGUI.CreateAPlayerStates.STATALLOCATION;
                }
            }
        }






    }

}
