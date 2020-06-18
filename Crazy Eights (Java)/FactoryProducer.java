package btp600.A2;

/**
 * Used to produce a particular type of abstract factory and return it to a particular Game.
 */
public class FactoryProducer {
    private static CardGameFactory gametype=null;

    /*Creates the appropriate factory based on what has been selected by the user.
    * Returns that factory so that the game may create the appropriate products for that game
    * Called in, in this case, BigTwoGame's constructor.
    */
   public static CardGameFactory getFactory(String game)
    {
        //constructs BigTwoFactory which creates the associated products for Big Two
      if (game.equalsIgnoreCase("Crazy Eights"))
           gametype = new CrazyEightsFactory();

        return gametype;

    }
}
