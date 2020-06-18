package btp600.a3.vmmirabella;

import java.util.ArrayList;
import java.util.List;

/**
 * Abstract class that contains a template method, containing common methods and some implementations that will be the same across all games.
 * Basic structure that is common across all games.
 */
public abstract class Game {
    protected Rules ruleSet;
    protected List<Player> players;
    protected Deck deck;
    protected Pile pile;
    protected static CardGameFactory cardGame;
    protected ScoringStrategy scoringStrat;

    //default constructor initializing players, deck and pile.
    public  Game() {
        players = new ArrayList<>();
        deck = new Deck();
        pile = null;//not every game uses a pile ie. GoFish. If a game uses pile they must initialize it in their specific game
    }

    /*Create the opening of a game. This involves setting the proper abstract factory to be made.
    * Creating the initial deck, dealing X cards to players as well as sorting their hand.
    * Each game will go through this process -> creating rules, setting strategy, creating the deck and then,
    *  specific to each game, creating # of players as well as how many cards each player will be dealt.
    *  **If we assume every game will only be against the computer than the 2 methods in BigTwoGame to create players will be placed here.
    */
    public void initializeGame(){

        ruleSet = cardGame.makeRules(); // create rules
        scoringStrat = cardGame.setStrategy(); // set scoring Strategy

        deck.initializeFullDeck();//create deck
    }

    /*A player will take their turn and attempt to play a card based on the rules of the game.
    * Rules are specific to each game. This method will be the same for all games. Each player's takeTurn method
    * will be specific to the game and coded in BigTwoComputer or BigTwoHuman in this case.
    */
    public void playerTurn(Player player){ player.takeTurn(ruleSet, deck, pile);}

    /*Checks for game specific statements, such as a player's hand is empty to denote that the game has ended.
    *Then it will calculate the score of every player and display the winner.
    */
    public abstract boolean gameOver();

    /* Template method stating that every game will be played in this order. A game will first be
    * initialized (create appropriate abstract factory, objects, create deck and deal cards to players),
    * then players will take their turn while the GameOver() method is true (meaning the game hasn't finished so
    * they may take their turn (could be a condition where it checks players to see if their hand is empty - depends on the game)
    */
    public void playGame()
    {
        initializeGame();//initialize objects used in the game

        int numPlayers=players.size();

        //Randomly selects who plays first. # from 0-5 will be generated then mod 2 to get 0 or 1(player 1 or 2).
        int turn =(int)(Math.random() *(5) % numPlayers);//// TODO: 4/12/2016 changed to %numplayers 

        System.out.println("\nStart of Game!");//// FIXME: 4/12/2016 moved from do/while
        
        do//do and while the game hasn't ended, have players take their turns
        {            
            playerTurn(players.get(turn));//get the appropriate player and have them take their turn

            turn = (turn + 1) % numPlayers;// go to the next player
        }while(!gameOver());
    }


}
