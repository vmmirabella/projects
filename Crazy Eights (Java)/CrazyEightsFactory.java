package btp600.A2;

/**
 * Created by VM on 4/2/2016.
 */
public class CrazyEightsFactory extends CardGameFactory{
    
    //creates and returns a CrazyEightsRules object
    public Rules makeRules() {return new CrazyEightsRules();}

    //creates and returns a CrazyEightsComputer object passing a string parameter to determine the name of the computer player
    public Player makeComputer(String n){
        return new CrazyEightsComputer(n);
    }

    //creates and returns a CrazyEightsHuman object passing a string parameter to determine the name of the human player
    public Player makeHuman(String n)
    {
        return new CrazyEightsHuman(n);
    }

  //creates and returns the scoring strategy that will be used
    public ScoringStrategy setStrategy() { return new CrazyEightsScoring();  }
}
