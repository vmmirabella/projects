using System.Collections;
using System.Collections.Generic;
using UnityEngine;

//logic is in DisplayCreatePlayerFunctions (functions are called from that class)
public class CreateAPlayerGUI : MonoBehaviour
{
    public enum CreateAPlayerStates
    {
        CLASSSELECTION, //display all class types
        STATALLOCATION, //allocate stats where players want to
        FINALSETUP //add name and misc items (anything missing)

    }

    public static CreateAPlayerStates currentState;
    private DisplayCreatePlayerFunctions displayFunctions = new DisplayCreatePlayerFunctions();


    // Start is called before the first frame update
    void Start()
    {
         currentState = CreateAPlayerStates.CLASSSELECTION;
        //currentState = CreateAPlayerStates.STATALLOCATION;
    }

    // Update is called once per frame
    void Update()
    {
        switch (currentState)
        {
            case (CreateAPlayerStates.CLASSSELECTION):
                break;
            case (CreateAPlayerStates.STATALLOCATION):
                break;
            case (CreateAPlayerStates.FINALSETUP):
                break;
        }
    }

    void OnGUI()
    {
        //displays elements that are common between all other gui "states"
         displayFunctions.DisplayMainItems();

        if (currentState == CreateAPlayerStates.CLASSSELECTION)
        {
            displayFunctions.DisplayClassSelections();
        }

        if (currentState == CreateAPlayerStates.STATALLOCATION)
        {
            displayFunctions.DisplayStatAllocation();
        }

        if (currentState == CreateAPlayerStates.FINALSETUP)
        {
            displayFunctions.DisplayFinalSetup();
        }
    }
}
