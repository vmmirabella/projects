package btp600.a3.vmmirabella;

/**
 * Rule system for the game. This class would state things such as what is allowed to be played, when you are
 * allowed to make a certain move...etc. Essentially makes sure the player is able to make a move within the
 * confines of the rules of that particular game.
 */
public abstract class Rules {

    /*abstract method since each game will have rules specific to their respective games.
    *If a move is valid then it will return true, if a move isn't allowed based on the rules then it returns false.
    */
    public abstract boolean isValid(Card c, Card c2 ); //// TODO: 4/11/2016 changed
}
