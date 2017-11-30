<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:template match="/">
  <html>
    <meta charset="UTF-8"></meta>
    <title>Preguntas from xml>>xsl to html</title>
    <style>
      #xml_table {
      margin: auto;
      padding: 1%;
      border: 2px;
      border-bottom-color: dodgerblue;
      background-color: rgba(10, 56, 75, 0.53);
      }

      #xml_table tr{
      margin: auto;
      padding: 0%;
      border: 2px;
      border-bottom-color: dodgerblue;
      background-color: rgb(255, 253, 219);
      }

      #xml_table td p {
      margin-left: 2%;
      margin-right: 5%;
      margin-top: 3%;
      margin-bottom: 1%;
      }

      li {
      margin-left: 10%;
      }
    </style>
  <body>
    <h2 align="center">Preguntas con xsl </h2>
    <div style="width:1024px; height:512px; overflow:auto;">
    <table id="xml_table" cellspacing="0" cellpadding="0" border="1" width="512px">
      <tr bgcolor="#aacdfa">
        <th>assesmentItem</th>
        <th>itemBody</th>
          <th>correctResponse</th>
          <th>incorrectResponse</th>
      </tr>

      <xsl:for-each select="/assessmentItems/assessmentItem">
        <tr>
          <td><p>complexity:
          <xsl:value-of select="attribute::complexity"/></p>
            <p>subject:
              <xsl:value-of select="attribute::subject"/></p>
            <p>author:
            <xsl:value-of select="attribute::author"/></p></td>
          <td><xsl:value-of select="itemBody/p"/></td>
          <td><xsl:value-of select="correctResponse/value"/></td>
        <td><xsl:for-each select="incorrectResponses/value">
            <li><xsl:value-of select="."/></li>
            </xsl:for-each></td>
        </tr>
      </xsl:for-each>
    </table>
    </div>
  </body>
  </html>
</xsl:template>
</xsl:stylesheet>
