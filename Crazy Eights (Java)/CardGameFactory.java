package btp600.a3.vmmirabella;

/**
 * Signals that Rules, players and scoring should be created together.
 * When a new game is created they must create these objects (which are specific for each game)
 */
public abstract class CardGameFactory {

    //creates sets of rules for the game
    public abstract Rules makeRules();

    //creates human and computer player //// TODO: 4/12/2016 changed parameters to strings
    public abstract Player makeHuman(String n);
    public abstract Player makeComputer(String n);

    //sets the scoring strategy that will be used in the current game
    public abstract ScoringStrategy setStrategy();
}
