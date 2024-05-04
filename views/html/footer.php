<style>


  .footer_section h4 {
    font-size: 28px;
  }

  .footer_section h4,
  .footer_section .footer-logo {

    font-family: 'Arial', cursive;
  }

  .footer_section p {
    color: #dbdbdb;
  }

  .footer_section .footer-col {
    margin-bottom: 30px;
  }

  .footer_section .footer_contact .contact_link_box {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
  }

  .footer_section .footer_contact .contact_link_box a {

    color: #ffffff;
  }

  .footer_section .footer_contact .contact_link_box a i {
    margin-right: 5px;
  }

  .footer_section .footer_contact .contact_link_box a:hover {
    color: #00b2ae;
  }

  .footer_section .footer-logo {
    display: block;
    font-weight: bold;
    font-size: 38px;
    line-height: 1;
    color: #ffffff;
  }

  .footer_section .footer_social {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    margin-top: 20px;
    margin-bottom: 10px;
  }

  .footer_section .footer_social a {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    color: #222831;
    width: 30px;
    height: 30px;
    border-radius: 10%;
    background-color: #00b2ae;
    border-radius: 100%;
    margin: 0 2.5px;
    font-size: 18px;
  }

  .footer_section .footer_social a:hover {
    color: #ffbe33;
  }

  .footer_section .footer-info {
    text-align: center;
    margin-top: 25px;
  }

  .footer_section .footer-info p {
    color: #ffffff;
    margin: 0;
  }

  .footer_section .footer-info p a {
    color: inherit;
  }

  /*# sourceMappingURL=style.css.map */
  .category-box {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 5px;
    color: white;
    font-weight: bold;
  }

  /* Style for the map container */
  .map_main {
    margin-top: 20px;
  }

  /* Responsive styling for the map */
  .map-responsive {
    overflow: hidden;
    padding-bottom: 56.25%;
    position: relative;
    height: 0;
  }

  .map-responsive iframe {
    left: 0;
    top: 0;
    height: 100%;
    width: 100%;
    position: absolute;
  }
  .footer_section {
    background-color: #222831;
    color: #ffffff;
    width: 100%;
    position:relative;
    bottom: 0;
    left: 0;
  }
</style>
<br><br><br><br><br>
<footer class="footer_section fixed-bottom">
  <div class="container">
    <div class="row">
      <div class="col-md-4 footer-col">
        <div class="footer_contact">
          <h4>
            Asotaeco
          </h4>
          <div class="contact_link_box">

            <a href="../infoempresa/informacion.php">
              <span>
                Quienes somos
              </span>
            </a>
          </div>
        </div>
      </div>
      <div class="col-md-4 footer-col">
        <div class="footer_contact">
          <h4>
            Contacto
          </h4>
          <div class="contact_link_box">

            <a href="">
              <i class="fa fa-phone" aria-hidden="true"></i>
              <span>
                Call +593 99 523 6593
              </span>
            </a>
            <a href="">
              <i class="fa fa-envelope" aria-hidden="true"></i>
              <span>
                asotaec@hotmail.com
              </span>
            </a>
            <div class="footer_contact"><br>
              <h4>
                Redes sociales
              </h4>
              <div class="social-icons">
                <a href="https://www.facebook.com/margoty1987" target="_blank">

                  <i class="fa fa-facebook"></i>
                  Facebook
              </div>
              </a>
              <div class="footer_contact"><br>
                <h4>
                  Terminos legales
                </h4>
                <div class="reglamento">
                  <a href="ESTATUTO.pdf" download="Estatuto.pdf">
                    <i class="fas fa-file-pdf"></i> Estatuto
                  </a>
                </div>

                <div class="reglamento">
                  <a href="reglamento-interno (1).pdf" download="Reglamento Interno.pdf">
                    <i class="fas fa-file-pdf"></i> Reglamento Interno
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 footer-col">

        <h4>
          Hora de Atencion
        </h4>
        <span>
          Lunes - Viernes
        </span>
        <p>
          7.00 Am -6.00 Pm
        </p>
        <h4>
          Ubicación
        </h4>
        <i class="fa fa-map-marker" aria-hidden="true"></i>
        <span>
          Barrio “Las Palmas”, calle Ayahuasca
        </span>
        <div class="map_main">
          <div class="map-responsive">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.2313560558673!2d-77.81956842526523!3d-0.9828160353692498!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d6a5fdca06774d%3A0x5dbc3647ff4e1453!2sAsociaci%C3%B3n%20%22Asotaeco%22!5e0!3m2!1ses!2sec!4v1706770322235!5m2!1ses!2sec" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>

      </div>

    </div>

  </div>
  <p class="text-muted text-center">Copyright © <?php echo date("Y"); ?> Asotaeco. Todos los derechos reservados.</p>
</footer>